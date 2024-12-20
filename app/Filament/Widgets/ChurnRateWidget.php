<?php

namespace App\Filament\Widgets;

use App\Library\Enums\Permissions;
use App\Models\Subscription;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ChurnRateWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $now = Carbon::now();
        $thirtyDaysAgo = $now->copy()->subDays(30);

        // Query: Total Subscribers 30 Days Ago
        $totalSubscribers30DaysAgo = Subscription::query()
            ->where('started_at', '<=', $thirtyDaysAgo)
            ->where(function ($query) use ($thirtyDaysAgo) {
                $query->whereNull('canceled_at') // Active subscriptions
                ->orWhere('canceled_at', '>', $thirtyDaysAgo); // Canceled after 30 days ago
            })
            ->count();

        // Query: Churned Subscribers in the Last 30 Days
        $churnedSubscribers = Subscription::query()
            ->whereBetween('canceled_at', [$thirtyDaysAgo, $now])
            ->count();

        // Calculate Churn Rate
        $churnRate = $totalSubscribers30DaysAgo > 0
            ? ($churnedSubscribers / $totalSubscribers30DaysAgo) * 100
            : 0;

        // Return the Stat widget
        return [
            Stat::make('Churn Rate', number_format($churnRate, 2) . '%')
                ->description('Last 30 days')
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color($churnRate > 10 ? 'danger' : 'success'),
        ];
    }

    public static function canView(): bool
    {
        // Use Filament's logged-in user to check roles or permissions
        return Filament::auth()->user()?->can(Permissions::VIEW_CHURN_WIDGET);
    }
}
