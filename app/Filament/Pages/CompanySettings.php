<?php

namespace App\Filament\Pages;

use App\Models\CompanySetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class CompanySettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 99;
    protected static string $view = 'filament.pages.company-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'company_name' => CompanySetting::get('company_name', ''),
            'company_email' => CompanySetting::get('company_email', ''),
            'company_phone' => CompanySetting::get('company_phone', ''),
            'company_address' => CompanySetting::get('company_address', ''),
            'company_vat' => CompanySetting::get('company_vat', ''),
            'invoice_prefix' => CompanySetting::get('invoice_prefix', 'INV-'),
            'invoice_footer' => CompanySetting::get('invoice_footer', ''),
            'default_currency' => CompanySetting::get('default_currency', 'EUR'),
            'default_tax_rate' => CompanySetting::get('default_tax_rate', '22'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('🏢 Company Information')->schema([
                Forms\Components\TextInput::make('company_name')
                    ->label('Company Name')
                    ->required(),
                Forms\Components\TextInput::make('company_email')
                    ->label('Email')
                    ->email(),
                Forms\Components\TextInput::make('company_phone')
                    ->label('Phone'),
                Forms\Components\Textarea::make('company_address')
                    ->label('Address')
                    ->rows(2),
                Forms\Components\TextInput::make('company_vat')
                    ->label('VAT / Tax ID'),
            ])->columns(2),

            Forms\Components\Section::make('🧾 Invoice Settings')->schema([
                Forms\Components\TextInput::make('invoice_prefix')
                    ->label('Invoice Number Prefix')
                    ->placeholder('INV-'),
                Forms\Components\TextInput::make('default_currency')
                    ->label('Default Currency')
                    ->placeholder('EUR'),
                Forms\Components\TextInput::make('default_tax_rate')
                    ->label('Default Tax Rate (%)')
                    ->numeric()
                    ->suffix('%'),
                Forms\Components\Textarea::make('invoice_footer')
                    ->label('Invoice Footer Text')
                    ->rows(2)
                    ->columnSpanFull(),
            ])->columns(3),
        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            CompanySetting::set($key, $value);
        }

        Notification::make()
            ->title('Settings saved!')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('💾 Save Settings')
                ->action('save'),
        ];
    }
}
