<?php

namespace App\Filament\Client\Resources\ClientTicketResource\Pages;

use App\Filament\Client\Resources\ClientTicketResource;
use App\Models\AppNotification;
use Filament\Actions;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewClientTicket extends ViewRecord
{
    protected static string $resource = ClientTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Reply
            Actions\Action::make('reply')
                ->label('Reply')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('primary')
                ->form([
                    Forms\Components\RichEditor::make('body')
                        ->label('Your Reply')
                        ->required(),
                    Forms\Components\FileUpload::make('reply_attachments')
                        ->label('Attach Files')
                        ->multiple()
                        ->directory('ticket-reply-attachments')
                        ->maxSize(10240),
                ])
                ->action(function (array $data) {
                    $this->record->replies()->create([
                        'user_id' => auth()->id(),
                        'body' => $data['body'],
                        'is_internal_note' => false,
                        'attachments' => $data['reply_attachments'] ?? null,
                    ]);

                    // If ticket was waiting on client, move back to in_progress
                    if ($this->record->status === 'waiting') {
                        $this->record->update(['status' => 'in_progress']);
                    }

                    // Notify assigned staff
                    if ($this->record->assigned_to) {
                        AppNotification::notify(
                            $this->record->assigned_to,
                            'ticket_client_reply',
                            'Client replied on ' . $this->record->ticket_number,
                            strip_tags(substr($data['body'], 0, 200)),
                            '/admin/tickets/' . $this->record->id
                        );
                    }

                    $this->refreshFormData(['*']);
                })
                ->hidden(fn() => $this->record->status === 'closed'),

            // Rate Experience (only on resolved/closed and unrated)
            Actions\Action::make('rate')
                ->label('⭐ Rate Experience')
                ->icon('heroicon-o-star')
                ->color('warning')
                ->form([
                    Forms\Components\Radio::make('satisfaction_rating')
                        ->label('How would you rate the support?')
                        ->options([
                            5 => '⭐⭐⭐⭐⭐ Excellent',
                            4 => '⭐⭐⭐⭐ Good',
                            3 => '⭐⭐⭐ Average',
                            2 => '⭐⭐ Below Average',
                            1 => '⭐ Poor',
                        ])
                        ->required(),
                    Forms\Components\Textarea::make('satisfaction_comment')
                        ->label('Any additional feedback?')
                        ->rows(3)
                        ->placeholder('Optional — Tell us how we can improve'),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'satisfaction_rating' => $data['satisfaction_rating'],
                        'satisfaction_comment' => $data['satisfaction_comment'] ?? null,
                    ]);

                    // Notify assigned staff about rating
                    if ($this->record->assigned_to) {
                        AppNotification::notify(
                            $this->record->assigned_to,
                            'ticket_rated',
                            $this->record->ticket_number . ' rated ' . str_repeat('⭐', $data['satisfaction_rating']),
                            $data['satisfaction_comment'] ?? 'No comment provided.',
                            '/admin/tickets/' . $this->record->id
                        );
                    }

                    $this->refreshFormData(['*']);
                })
                ->hidden(fn() => $this->record->satisfaction_rating !== null
                    || !in_array($this->record->status, ['resolved', 'closed'])),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Ticket Details')->schema([
                Infolists\Components\TextEntry::make('ticket_number')->weight('bold'),
                Infolists\Components\TextEntry::make('subject'),
                Infolists\Components\TextEntry::make('category')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? ucfirst($state) : '—'),
                Infolists\Components\TextEntry::make('website.name')->default('—'),
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
                Infolists\Components\TextEntry::make('created_at')->dateTime(),
            ])->columns(4),

            // Satisfaction display (if rated)
            Infolists\Components\Section::make('Your Rating')
                ->schema([
                    Infolists\Components\TextEntry::make('satisfaction_rating')
                        ->label('Rating')
                        ->formatStateUsing(fn($state) => str_repeat('⭐', $state) . " ({$state}/5)"),
                    Infolists\Components\TextEntry::make('satisfaction_comment')
                        ->label('Your Feedback')
                        ->default('No comment'),
                ])
                ->columns(2)
                ->visible(fn() => $this->record->satisfaction_rating !== null),

            Infolists\Components\Section::make('Description')->schema([
                Infolists\Components\TextEntry::make('description')
                    ->html()->columnSpanFull(),
            ]),

            // Conversation (only non-internal notes)
            Infolists\Components\Section::make('Conversation')
                ->schema(function () {
                    $replies = $this->record->replies()
                        ->where('is_internal_note', false)
                        ->with('user')
                        ->get();

                    if ($replies->isEmpty()) {
                        return [
                            Infolists\Components\TextEntry::make('no_replies')
                                ->label('')
                                ->default('No replies yet. Our team will respond soon!')
                                ->columnSpanFull(),
                        ];
                    }

                    return $replies->map(function ($reply, $index) {
                        $isStaff = $reply->user && $reply->user->role !== 'client';
                        $prefix = $isStaff ? '🛡️ Seeda Team' : '👤 You';

                        return Infolists\Components\Group::make([
                            Infolists\Components\TextEntry::make("replies.{$index}.header")
                                ->label('')
                                ->state(
                                    $prefix .
                                    ' • ' . $reply->created_at->diffForHumans()
                                )
                                ->weight('bold')
                                ->color($isStaff ? 'primary' : 'gray'),
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
