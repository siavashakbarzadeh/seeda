<?php

namespace App\Filament\Client\Resources\ClientTicketResource\Pages;

use App\Filament\Client\Resources\ClientTicketResource;
use App\Models\AppNotification;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateClientTicket extends CreateRecord
{
    protected static string $resource = ClientTicketResource::class;

    protected function afterCreate(): void
    {
        $ticket = $this->record;
        $clientName = auth()->user()?->name ?? 'A client';

        // Notify all admin users about the new ticket
        $admins = User::where('role', 'admin')->where('is_active', true)->get();
        foreach ($admins as $admin) {
            AppNotification::notify(
                $admin->id,
                'new_ticket',
                '🎫 New Ticket: ' . $ticket->ticket_number,
                $clientName . ' submitted: "' . $ticket->subject . '" [' . ucfirst($ticket->priority) . ' priority]',
                '/admin/tickets/' . $ticket->id
            );
        }

        // Also notify support agents
        $supportUsers = User::where('role', 'support')->where('is_active', true)->get();
        foreach ($supportUsers as $agent) {
            AppNotification::notify(
                $agent->id,
                'new_ticket',
                '🎫 New Ticket: ' . $ticket->ticket_number,
                $clientName . ' submitted: "' . $ticket->subject . '"',
                '/admin/tickets/' . $ticket->id
            );
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
