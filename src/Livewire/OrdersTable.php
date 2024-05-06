<?php

namespace Apydevs\Orders\Livewire;

use Apydevs\Customers\Models\Customer;
use Apydevs\Orders\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class OrdersTable extends DataTableComponent
{
    protected $model = Order::class;


    public function configure(): void
    {
        $this->setPrimaryKey('id');

    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->hideIf(true)
                ->sortable()->searchable(),
            Column::make('Total', 'total_price')
                ->hideIf(true)
                ->sortable()->searchable(),
            Column::make('Payment Schedule', 'payment_schedule')
                ->hideIf(true)
                ->sortable()->searchable(),
            Column::make('Duration', 'duration')
                ->hideIf(true)
                ->sortable()->searchable(),
            Column::make('AccountNo', 'customer_account_no')->sortable()->searchable(),
            Column::make('Name')->label(fn ($row, Column $column) => $row->customer->first_name. ' ' . $row->customer->last_name),
            Column::make('Schedule')->label(fn ($row, Column $column) => strtoupper(str_replace('_',' ',$row->payment_schedule)). ' over ' . $row->duration.' Payments')->searchable()->sortable(),

            Column::make('Total','total_price')->label(fn ($row, Column $column) =>'£'.number_format($row->total_price,2))->searchable()->sortable(),

            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('customers::components.livewire.datatables.action-column')->with(
                        [
                            'editLink' =>  $row,
                            'deleteLink' => route('customers.destroy', $row),
                            'hoverName' => $row->first_name. ' ' . $row->last_name,
                            'id'=>$row->id
                        ]
                    )
                )->html(),
//        Column::make('Deleted At', 'deleted_at') // If you are using soft deletes
//        ->sortable()
        ];
    }

    public function builder(): Builder
    {
        return Order::query()->with(['customer']);
    }
}
