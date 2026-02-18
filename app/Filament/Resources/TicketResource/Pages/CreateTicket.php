<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\AppNotification;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function afterCreate(): void
    {
        $ticket = $this->record;

        // If ticket has a client, notify the client's user
        if ($ticket->client_id) {
            $clientUser = User::where('client_id', $ticket->client_id)->first();
            if ($clientUser) {
                AppNotification::notify(
                    $clientUser->id,
                    'ticket_created',
                    '🎫 New Ticket Created: ' . $ticket->ticket_number,
                    'A support ticket has been created for you: "' . $ticket->subject . '"',
                    '/portal/client-tickets/' . $ticket->id
                );
            }
        }

        // If assigned, notify the assigned user
        if ($ticket->assigned_to && $ticket->assigned_to !== auth()->id()) {
            AppNotification::notify(
                $ticket->assigned_to,
                'ticket_assigned',
                '🎫 Ticket Assigned: ' . $ticket->ticket_number,
                'You have been assigned to: "' . $ticket->subject . '"',
                '/admin/tickets/' . $ticket->id
            );
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
