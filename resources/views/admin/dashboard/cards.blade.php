<div class="tf-section-4 mb-30">

    {{-- TOTAL SALES --}}
    <div class="wg-chart-default">
        <div class="flex items-center justify-between">
            <div>
                <div class="body-text mb-2">Total Orders</div>
                <h4>{{ $totalOrders }}</h4>
            </div>
            <div class="box-icon-trending up">
                <i class="icon-trending-up"></i>
                <div class="body-title number">1.56%</div>
            </div>
        </div>
        <div id="line-chart-1"></div>
    </div>

    {{-- Today Orders --}}
    <div class="wg-chart-default">
        <div class="flex items-center justify-between">
            <div>
                <div class="body-text mb-2">Today Orders</div>
                <h4>{{ $todayOrders }}</h4>
            </div>
            <div class="box-icon-trending down">
                <i class="icon-trending-down"></i>
                <div class="body-title number">1.56%</div>
            </div>
        </div>
        <div id="line-chart-2"></div>
    </div>

    {{-- Total Revenue --}}
    <div class="wg-chart-default">
        <div class="flex items-center justify-between">
            <div>
                <div class="body-text mb-2">Total Revenue</div>
                <h4>₹{{ number_format($totalRevenue) }}</h4>
            </div>
        </div>
        <div id="line-chart-3"></div>
    </div>

    {{-- Pending Orders --}}
    <div class="wg-chart-default">
        <div class="flex items-center justify-between">
            <div>
                <div class="body-text mb-2">Pending Orders</div>
                <h4>{{ $pendingOrders }}</h4>
            </div>
            <div class="box-icon-trending up">
                <i class="icon-trending-up"></i>
                <div class="body-title number">1.56%</div>
            </div>
        </div>
        <div id="line-chart-4"></div>
    </div>

</div>