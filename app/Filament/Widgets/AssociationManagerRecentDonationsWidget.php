<?php

namespace App\Filament\Widgets;

use App\Services\DashboardService;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AssociationManagerRecentDonationsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Donations';

    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 6;
    public ?Collection $records = null;
    public static function canView(): bool
    {
        return auth()->user()->type === 'association_manager';
    }
    public function getHeading(): string
    {
        return __('dashboard.Recent Donations');
    }
    public function getTableHeading(): string|null
    {
        return __('dashboard.Recent Donations');
    }
    protected function getTableQuery(): Builder
    {
        // This is a placeholder. We're not actually using this method directly.
        // Instead, we're manually loading data in getTableContent().
        return \App\Models\Donation::query()->limit(0);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('donor.name')
                ->label(__('Donor'))
                ->searchable(),

            TextColumn::make('campaign.name')
                ->label(__('Campaign'))
                ->searchable(),

            TextColumn::make('amount')
                ->label(__('Amount'))
                ->money(config('app.currency', 'EGP')),

            TextColumn::make('created_at')
                ->label(__('Date'))
                ->dateTime()
                ->sortable(),
        ];
    }

    public function getTableRecordsPerPage(): int
    {
        return 5;
    }

    public function getTableContent(): ?\Illuminate\Contracts\View\View
    {
        $dashboardService = new DashboardService();

        // Get association IDs for current user
        $associationIds = auth()->user()->associations()
            ->select('associations.id')
            ->pluck('associations.id')
            ->toArray();

        $recentDonations = $dashboardService->getRecentDonations($associationIds);

        $this->records = $recentDonations;

        return null;
    }
}
