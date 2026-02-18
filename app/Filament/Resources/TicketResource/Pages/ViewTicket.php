<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Mail\TicketReplyNotification;
use App\Models\AppNotification;
use App\Models\TicketReply;
use Filament\Actions;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('reply')
                ->label('Reply')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('primary')
                ->form([
                    Forms\Components\RichEditor::make('body')
                        ->label('Your Reply')
                        ->required(),
                    Forms\Components\Toggle::make('is_internal_note')
                        ->label('🔒 Internal Note (not visible to client)')
                        ->default(false),
                    Forms\Components\FileUpload::make('reply_attachments')
                        ->label('Attach Files')
                        ->multiple()
                        ->directory('ticket-reply-attachments')
                        ->maxSize(10240),
                ])
                ->action(function (array $data) {
                    $reply = $this->record->replies()->create([
                        'user_id' => auth()->id(),
                        'body' => $data['body'],
                        'is_internal_note' => $data['is_internal_note'] ?? false,
                        'attachments' => $data['reply_attachments'] ?? null,
                    ]);

                    // Mark first response time
                    $this->record->markFirstResponse();

                    // Auto-update status to in_progress if it was open
                    if ($this->record->status === 'open') {
                        $this->record->update(['status' => 'in_progress']);
                    }

                    // Send email notification to client (only for non-internal notes)
                    if (!($data['is_internal_note'] ?? false) && $this->record->client?->email) {
                        try {
                            Mail::to($this->record->client->email)
                                ->send(new TicketReplyNotification($this->record, strip_tags($data['body'])));
                        } catch (\Exception $e) {
                            // Log but don't block
                        }
                    }

                    // Create in-app notification for client user
                    if (!($data['is_internal_note'] ?? false)) {
                        $clientUser = \App\Models\User::where('client_id', $this->record->client_id)->first();
                        if ($clientUser) {
                            AppNotification::notify(
                                $clientUser->id,
                                'ticket_reply',
                                'New reply on ticket ' . $this->record->ticket_number,
                                strip_tags(substr($data['body'], 0, 200)),
                                '/portal/client-tickets/' . $this->record->id
                            );
                        }
                    }

                    $this->refreshFormData(['*']);
                }),

            Actions\Action::make('change_status')
                ->label('Change Status')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->form([
                    Forms\Components\Select::make('status')
                        ->options([
                            'open' => '📬 Open',
                            'in_progress' => '🔄 In Progress',
                            'waiting' => '⏳ Waiting on Client',
                            'resolved' => '✅ Resolved',
                            'closed' => '🔒 Closed',
                        ])->required()
                        ->default(fn() => $this->record->status),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => $data['status'],
                        'closed_at' => $data['status'] === 'closed' ? now() : $this->record->closed_at,
                    ]);

                    // Notify client of status change
                    $clientUser = \App\Models\User::where('client_id', $this->record->client_id)->first();
                    if ($clientUser) {
                        AppNotification::notify(
                            $clientUser->id,
                            'ticket_status',
                            'Ticket ' . $this->record->ticket_number . ' status changed',
                            'Status changed to: ' . ucfirst(str_replace('_', ' ', $data['status'])),
                            '/portal/client-tickets/' . $this->record->id
                        );
                    }

                    $this->refreshFormData(['*']);
                }),

            Actions\Action::make('resolve')
                ->label('Resolve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => 'resolved']);

                    $clientUser = \App\Models\User::where('client_id', $this->record->client_id)->first();
                    if ($clientUser) {
                        AppNotification::notify(
                            $clientUser->id,
                            'ticket_resolved',
                            'Ticket ' . $this->record->ticket_number . ' resolved!',
                            'Your ticket "' . $this->record->subject . '" has been resolved. Please rate your experience.',
                            '/portal/client-tickets/' . $this->record->id
                        );
                    }
                })
                ->hidden(fn() => in_array($this->record->status, ['resolved', 'closed'])),

            Actions\Action::make('close')
                ->label('Close')
                ->icon('heroicon-o-lock-closed')
                ->color('gray')
                ->requiresConfirmation()
                ->action(fn() => $this->record->update([
                    'status' => 'closed',
                    'closed_at' => now(),
                ]))
                ->hidden(fn() => $this->record->status === 'closed'),

            Actions\Action::make('reopen')
                ->label('Reopen')
                ->icon('heroicon-o-lock-open')
                ->color('info')
                ->requiresConfirmation()
                ->action(fn() => $this->record->update([
                    'status' => 'open',
                    'closed_at' => null,
                ]))
                ->hidden(fn() => !in_array($this->record->status, ['resolved', 'closed'])),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Ticket Info')->schema([
                Infolists\Components\TextEntry::make('ticket_number')->weight('bold'),
                Infolists\Components\TextEntry::make('subject'),
                Infolists\Components\TextEntry::make('client.name')->default('—'),
                Infolists\Components\TextEntry::make('website.name')->default('—'),
                Infolists\Components\TextEntry::make('category')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? ucfirst($state) : '—'),
                Infolists\Components\TextEntry::make('priority')
                    ->badge()
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'orange' => 'high',
                        'danger' => 'urgent',
                    ]),
                Infolists\Components\TextEntry::make('status')
                    ->badge()
                    ->colors([
                        'info' => 'open',
                        'primary' => 'in_progress',
                        'warning' => 'waiting',
                        'success' => 'resolved',
                        'gray' => 'closed',
                    ]),
                Infolists\Components\TextEntry::make('assignedUser.name')
                    ->label('Assigned To')
                    ->default('Unassigned'),
                Infolists\Components\TextEntry::make('source')
                    ->formatStateUsing(fn($state) => ucfirst($state ?? 'portal')),
                Infolists\Components\TextEntry::make('created_at')->dateTime(),
            ])->columns(5),

            // SLA Section
            Infolists\Components\Section::make('SLA & Response')->schema([
                Infolists\Components\TextEntry::make('sla_hours')
                    ->label('SLA Target')
                    ->suffix(' hours')
                    ->default('No SLA'),
                Infolists\Components\TextEntry::make('response_time')
                    ->label('First Response')
                    ->default('Awaiting...')
                    ->color(fn() => $this->record->isSlaBreached() ? 'danger' : 'success'),
                Infolists\Components\TextEntry::make('sla_status')
                    ->label('SLA Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'met' => '✅ Met',
                        'breached' => '⚠️ Breached',
                        'overdue' => '🔴 Overdue',
                        'active' => '⏳ Active',
                        default => 'No SLA',
                    })
                    ->colors([
                        'success' => 'met',
                        'danger' => fn($state) => in_array($state, ['breached', 'overdue']),
                        'warning' => 'active',
                        'gray' => 'no_sla',
                    ]),
                Infolists\Components\TextEntry::make('satisfaction_rating')
                    ->label('Rating')
                    ->formatStateUsing(fn($state) => $state ? str_repeat('⭐', $state) . " ({$state}/5)" : 'Not rated yet'),
                Infolists\Components\TextEntry::make('satisfaction_comment')
                    ->label('Feedback')
                    ->default('—'),
            ])->columns(5)->collapsible(),

            // Tags
            Infolists\Components\Section::make('Tags')->schema([
                Infolists\Components\TextEntry::make('tags')
                    ->badge()
                    ->separator(',')
                    ->color('gray')
                    ->columnSpanFull()
                    ->default('No tags'),
            ])->collapsible()->collapsed(),

            Infolists\Components\Section::make('Description')->schema([
                Infolists\Components\TextEntry::make('description')
                    ->html()
                    ->columnSpanFull(),
            ]),

            // Conversation
            Infolists\Components\Section::make('Conversation')
                ->schema(function () {
                    $replies = $this->record->replies()->with('user')->get();

                    if ($replies->isEmpty()) {
                        return [
                            Infolists\Components\TextEntry::make('no_replies')
                                ->label('')
                                ->default('No replies yet. Use the Reply button above to respond.')
                                ->columnSpanFull(),
                        ];
                    }

                    return $replies->map(function ($reply, $index) {
                        $isStaff = $reply->user && $reply->user->role !== 'client';
                        $prefix = $isStaff ? '🛡️ ' : '👤 ';
                        $noteTag = $reply->is_internal_note ? ' 🔒 Internal Note' : '';

                        return Infolists\Components\Group::make([
                            Infolists\Components\TextEntry::make("replies.{$index}.header")
                                ->label('')
                                ->state(
                                    $prefix .
                                    ($reply->user?->name ?? 'System') .
                                    ' • ' . $reply->created_at->diffForHumans() .
                                    $noteTag
                                )
                                ->weight('bold')
                                ->color($reply->is_internal_note ? 'warning' : ($isStaff ? 'primary' : 'gray')),
                            Infolists\Components\TextEntry::make("replies.{$index}.body")
                                ->label('')
                                ->state($reply->body)
                                ->html()
                                ->columnSpanFull(),
                        ])->columnSpanFull();
                    })->toArray();
                }),
        ]);
    }
}
