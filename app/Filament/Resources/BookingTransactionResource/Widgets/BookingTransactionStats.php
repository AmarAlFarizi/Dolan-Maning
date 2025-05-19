<?php

namespace App\Filament\Resources\BookingTransactionResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\BookingTransactionResource\Widgets\BookingTransactionStats;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\BookingTransaction;

class BookingTransactionStats extends BaseWidget
{
    protected function getStats(): array
    {
            $totalTransactions = BookingTransaction::count();
            $approvedTransactions = BookingTransaction::where('is_paid', true)->count();
            $totalRevenue = BookingTransaction::where('is_paid',true)->sum('total_amount');
        return [
            Stat::make('Total Transaction', $totalTransactions)
                ->description('All Transaction')
                ->descriptionIcon('heroicon-o-currency-dollar'),

            Stat::make('Approved Transaction', $approvedTransactions)
                ->description('Approved Transaction')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Total Revenue','IDR'.number_format($totalRevenue))
                ->description('Revenue from approved transaction')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
        ];
    }
}
