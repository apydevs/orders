<?php

namespace Apydevs\Orders\Livewire;

use App\Traits\CaseInsensitiveSearch;
use Apydevs\Customers\Models\Customer;
use Apydevs\Orders\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class OrdersTable extends DataTableComponent
{
   // protected $model = Order::class;
    use CaseInsensitiveSearch;

    public $customerId = null;
    public $lastTen = false;
    public string $search = '';
    public function configure(): void
    {
        $this->setPrimaryKey('id');


        if($this->lastTen){
            $this->paginationIsDisabled();
            $this->setDefaultSort('id', 'desc');
            $this->setPerPageVisibilityStatus(false);
            $this->setSearchVisibilityStatus(false);
            $this->setFiltersVisibilityStatus(false);
            $this->setPaginationVisibilityStatus(false);
        }else{
            $this->setDefaultSort('created_at', 'DESC');
        }

    }

    public function columns(): array
    {
        return [
            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('orders::components.livewire.datatables.action-column')->with(
                        [
                            'editLink' =>  route('orders.show', $row),
//                            'deleteLink' => route('orders.destroy', $row),
//                            'hoverName' => $row->first_name. ' ' . $row->last_name,
                            'id'=>$row->id
                        ]
                    )
                )->html(),
            Column::make('ID', 'id')
                ->sortable()->searchable(),
            Column::make('Total', 'total_price')
                ->hideIf(true)
                ->sortable()->searchable(),
            Column::make('Payment Schedule', 'payment_schedule')
                ->hideIf(true),

            Column::make('Duration', 'duration')
                ->hideIf(true)
                ->sortable()->searchable(),
            Column::make('Firstname', 'customer.first_name')
                ->hideIf(true)
                ->sortable()->searchable( fn(Builder $query, $searchTerm) => $query->orWhere('customer.first_name','ILIKE','%'.$searchTerm.'%')),
            Column::make('Lastname', 'customer.last_name')
                ->hideIf(true)
                ->sortable()->searchable( fn(Builder $query, $searchTerm) => $query->orWhere('customer.last_name','ILIKE','%'.$searchTerm.'%')),


            Column::make('Status', 'status')->format(fn($item)=>ucfirst($item))->sortable()->searchable(),
            Column::make('Dispatched', 'dispatch_status')->format(fn($item)=>ucfirst($item))->sortable()->searchable(),
//            Column::make('Created Bu', 'user.name')->sortable()->searchable(),
            Column::make('AccountNo', 'customer.account_reference')->sortable()->searchable(),
            Column::make('Contact Number', 'customer.phone')->sortable()->searchable(),
            Column::make('Delivery Address', 'delivery_address')->sortable()->searchable(),
            Column::make('Billing Address', 'billing_address')->sortable()->searchable() ->deselected(),
//            Column::make('first_name','customer.full_name'),
          Column::make('Customer_id', 'customer_id')->sortable()->searchable(),

            Column::make('Name','customer.last_name') ->format(
                fn($value, $row, Column $column) => $row->customer->first_name. ' ' . $row->customer->last_name
            )->sortable()->searchable(),

            Column::make('Duration Weeks','duration')->searchable()->sortable(),
            Column::make('Payment Week','current_schedule')
                ->searchable()
                ->sortable(),
            BooleanColumn::make('Contract Phone','isContract')
                ->searchable()
                ->sortable(),
            Column::make('Total','total_price')->label(fn ($row, Column $column) =>'£'.number_format($row->total_price,2))->searchable()->sortable( fn(Builder $query, string $direction) => $query->orderBy('total_price',$direction)),

            DateColumn::make('Created', 'created_at')
                ->outputFormat('Y-m-d H:i')->searchable()->sortable(),
            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('orders::components.livewire.datatables.action-column')->with(
                        [
                            'editLink' =>  route('orders.show', $row),
//                            'deleteLink' => route('orders.destroy', $row),
//                            'hoverName' => $row->first_name. ' ' . $row->last_name,
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
        $query = Order::query()->with(['customer','user', 'getCurrentPaymentSchedule']);

        if ($this->customerId) {
            $query->where('customer_id', $this->customerId);
        }
        if($this->lastTen){

            $query->orderBy('created_at', 'desc')
                ->limit(10);
        }
        return $query;
    }


    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'All',
                    'awaiting-p1' => 'awaiting-p1',
                    'pending' => 'Pending',
                    'active' => 'Active',
                    'lapsed' => 'Lapsed',
                    'failed' => 'Failed',
                    'complete' => 'Completed',
                ])
                ->setFirstOption('All')
                ->filter(function(Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('status','iLike', '%'.$value.'%');
                    }
                }),

            SelectFilter::make('Dispatched')
                ->options([
                    '' => 'All',
                    'pre-dispatched' => 'PRE',
                    'part-dispatched' => 'PART',
                    'post-dispatched' => 'POST',

                ])
                ->setFirstOption('All')
                ->filter(function(Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('dispatch_status','iLike', '%'.$value.'%');
                    }
                }),
            TextFilter::make('Payment Week')
                ->config([
                    'placeholder' => 'Number',
                    'maxlength' => '3',
                ])
                ->filter(function (Builder $builder, $value) {
                    if (!empty($value)) {
                        $builder->where('current_schedule', '=', $value);
                    }
                }),
            SelectFilter::make('Phone Contract')
                ->options([
                    '' => 'All',
                    true => 'Yes',
                    false=> 'No',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('isContract', $value);
                    }
                }),
            DateRangeFilter::make('Order Period') ->config([
                'allowInput' => true,   // Allow manual input of dates
                'altFormat' => 'F j, Y', // Date format that will be displayed once selected
                'ariaDateFormat' => 'F j, Y', // An aria-friendly date format
                'dateFormat' => 'Y-m-d', // Date format that will be received by the filter
                'earliestDate' => Carbon::now()->subYears(2)->format('Y-m-d'), // The earliest acceptable date
                'latestDate' => Carbon::now()->format('Y-m-d'), // The latest acceptable date
                'placeholder' => 'Enter Date Range', // A placeholder value
            ])
                ->setFilterPillValues([0 => 'minDate', 1 => 'maxDate']) // The values that will be displayed for the Min/Max Date Values
                ->filter(function (Builder $builder, array $dateRange) { // Expects an array.
                    $builder
                        ->whereDate('orders.created_at', '>=', $dateRange['minDate']) // minDate is the start date selected
                        ->whereDate('orders.created_at', '<=', $dateRange['maxDate']); // maxDate is the end date selected
                }),

        ];
    }

}
