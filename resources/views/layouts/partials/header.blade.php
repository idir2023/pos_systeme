@inject('request', 'Illuminate\Http\Request')
<!-- Main Header -->
<header class="main-header no-print">
  <a href="{{route('home')}}" class="logo">

    <!--<span class="logo-lg">{{ Session::get('business.name') }} <i class="fa fa-circle text-success" id="online_indicator"></i></span> -->
    <img class="logo-lg" style="padding: 10px; width: 100px" src="https://manditechinfo.store/icon.webp" />
    <img style="width: 30px" display="none" src="https://manditechinfo.store/icon.webp" />
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      &#9776;
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="btn-group" style="hover: none;padding:padding:7px 3px">
      <button id="header_shortcut_dropdown" type="button"
        class="btn btn-success dropdown-toggle btn-flat m-8 btn-sm mt-10 " data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <i class="fas fa-plus fa-lg"></i>
      </button>
      <ul class="dropdown-menu">
        <div style="margin-left: 10px; margin-right: 10px;font-weight: bold;">@lang('sale.sells')</div>
        <hr style="margin: 1px;">
        <li>
          <a href="{{action([\App\Http\Controllers\SellController::class, 'create'], ['status' => 'quotation'])}}">
            <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('sale.add_Devis')</a>
        </li>
        @can('so.create')
        <li>
          <a href="{{action([\App\Http\Controllers\SellController::class, 'create'])}}?sale_type=sales_order">
            <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('sale.Bon_de_commade')</a>
        </li>
        @endcan

        @can('sell.create')
        <li>
          <a href="{{action([\App\Http\Controllers\SellController::class, 'create'])}}">
            <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('sale.bon_livraison')
          </a>
        </li>
        @endcan

        {{-- start --}}
        @if(session('business.facture'))
        @can('sell.create')
        <li>
          <a href="{{action([\App\Http\Controllers\SellController::class, 'create_facture'])}}">
            <i class="fas fa-plus-circle" id="facture_link" aria-hidden="true"></i> @lang('sale.facture')
          </a>
        </li>
        @endcan
        @endif

        {{-- end --}}

        <div style="margin-left: 10px; margin-right: 10px;font-weight: bold;">@lang('purchase.purchases')</div>
        <hr style="margin: 1px;">
        <li>
          @can('purchase_order.create')
          <a href="{{action([\App\Http\Controllers\PurchaseOrderController::class, 'create'])}}">
            <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('purchase.bon_commande')
          </a>
          @endcan
        </li>
        @can('purchase.create')
        <li>
          <a href="{{action([\App\Http\Controllers\PurchaseController::class, 'create'])}}">
            <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('purchase.bon_reception')
          </a>
        </li>

        @endcan
        <div style="margin-left: 10px; margin-right: 10px;font-weight: bold;">@lang('lang_v1.other')</div>
        <hr style="margin: 1px;">
        @can('product.create')
        <li>
          <a href="{{action([\App\Http\Controllers\ProductController::class, 'create'])}}">
            <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('sale.products')
          </a>
        </li>
        @endcan
        @can('expense.add')
        <li>
          <a href="{{action([\App\Http\Controllers\ExpenseController::class, 'create'])}}">
            <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('expense.expenses')
          </a>
        </li>
        @endcan
      </ul>
    </div>
    <div class="btn-group" style="hover: none;padding:padding:7px 3px">
      <button id="header_shortcut_dropdown" type="button"
        class="btn btn-success dropdown-toggle btn-flat pull-left m-8 btn-sm mt-10" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-star fa-lg"></i>
      </button>
      <ul class="dropdown-menu">
        @can('customer.view')
        <li>
          <a href="{{action([\App\Http\Controllers\ContactController::class, 'show'], 1)}}">
            <i class="fas fa-th-list" aria-hidden="true"></i> @lang('contact.customer_situation')
          </a>
        </li>
        @endcan
        @can('supplier.view')
        <li>
          <a href="{{action([\App\Http\Controllers\ContactController::class, 'show'], 2)}}">
            <i class="fas fa-th-list" aria-hidden="true"></i> @lang('contact.supplier_situation')
          </a>
        </li>
        @endcan
      </ul>
    </div>
    <div class="btn-group" style="hover: none;padding:7px 3px">
      <button id="header_shortcut_dropdown" type="button"
        class="btn btn-success dropdown-toggle btn-flat pull-left m-8 btn-sm mt-10" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-chart-bar fa-lg"></i>
      </button>
      <ul class="dropdown-menu">
        @can('profit_loss_report.view')
        <li>
          <a href="{{action([\App\Http\Controllers\ReportController::class, 'getProfitLoss'])}}">
            <i class="fa fas fa-file-invoice-dollar" aria-hidden="true"></i> @lang('report.profit_loss')
          </a>
        </li>
        @endcan
        @can('contacts_report.view')
        <li>
          <a href="{{action([\App\Http\Controllers\ReportController::class, 'getCustomerSuppliers'])}}">
            <i class="fa fas fa-address-book" aria-hidden="true"></i> @lang('report.contacts')
          </a>
        </li>
        @endcan
        @can('stock_report.view')
        <li>
          <a href="{{action([\App\Http\Controllers\ReportController::class, 'getStockReport'])}}">
            <i class="fa fas fa-hourglass-half" aria-hidden="true"></i> @lang('report.stock_report')
          </a>
        </li>
        @endcan
      </ul>
    </div>
    @if(Module::has('Superadmin'))
    @includeIf('superadmin::layouts.partials.active_subscription')
    @endif

    @if(!empty(session('previous_user_id')) && !empty(session('previous_username')))
    <a href="{{route('sign-in-as-user', session('previous_user_id'))}}"
      class="btn btn-flat btn-danger m-8 btn-sm mt-10"><i class="fas fa-undo"></i> @lang('lang_v1.back_to_username',
      ['username' => session('previous_username')] )</a>
    @endif

    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">

      <div class="m-8 pull-left mt-15 hidden-xs" style="color: #444;"><strong>{{ @format_date('now') }}</strong></div>

      @if(Module::has('Essentials'))
      @includeIf('essentials::layouts.partials.header_part')
      @endif
      <!--
        <div class="btn-group">          
          <button id="header_shortcut_dropdown" type="button" class="btn btn-success dropdown-toggle btn-flat pull-left m-8 btn-sm mt-10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-plus-circle fa-lg"></i>
          </button>
          <ul class="dropdown-menu">
            @can('sell.create')
              <li>
                <a href="{{action([\App\Http\Controllers\SellController::class, 'create'])}}">
                    <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('sale.sale')
                </a>
              </li>
            @endcan
            @can('purchase.create')
              <li>
                <a href="{{action([\App\Http\Controllers\PurchaseController::class, 'create'])}}">
                    <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('purchase.purchases')
                </a>
              </li>
            @endcan
            @can('product.create')
              <li>
                <a href="{{action([\App\Http\Controllers\ProductController::class, 'create'])}}">
                    <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('sale.products')
                </a>
              </li>
            @endcan
            @can('expense.add')
              <li>
                <a href="{{action([\App\Http\Controllers\ExpenseController::class, 'create'])}}">
                    <i class="fas fa-plus-circle" aria-hidden="true"></i> @lang('expense.expenses')
                </a>
              </li>
            @endcan
          </ul>
        </div>-->
      <!--
        <button id="btnCalculator" title="@lang('lang_v1.calculator')" type="button" class="btn btn-success btn-flat pull-left m-8 btn-sm mt-10 popover-default hidden-xs" data-toggle="popover" data-trigger="click" data-content='@include("layouts.partials.calculator")' data-html="true" data-placement="bottom">
            <strong><i class="fa fa-calculator fa-lg" aria-hidden="true"></i></strong>
        </button>
        -->

      @if($request->segment(1) == 'pos')
      @can('view_cash_register')
      <button type="button" id="register_details" title="{{ __('cash_register.register_details') }}"
        data-toggle="tooltip" data-placement="bottom"
        class="btn btn-success btn-flat pull-left m-8 btn-sm mt-10 btn-modal" data-container=".register_details_modal"
        data-href="{{ action([\App\Http\Controllers\CashRegisterController::class, 'getRegisterDetails'])}}">
        <strong><i class="fa fa-briefcase fa-lg" aria-hidden="true"></i></strong>
      </button>
      @endcan
      @can('close_cash_register')
      <button type="button" id="close_register" title="{{ __('cash_register.close_register') }}" data-toggle="tooltip"
        data-placement="bottom" class="btn btn-danger btn-flat pull-left m-8 btn-sm mt-10 btn-modal"
        data-container=".close_register_modal"
        data-href="{{ action([\App\Http\Controllers\CashRegisterController::class, 'getCloseRegister'])}}">
        <strong><i class="fa fa-window-close fa-lg"></i></strong>
      </button>
      @endcan
      @endif

      @if(in_array('pos_sale', $enabled_modules))
      @can('sell.create')
      <a href="{{action([\App\Http\Controllers\SellPosController::class, 'create'])}}" title="@lang('sale.pos_sale')"
        data-toggle="tooltip" data-placement="bottom" class="btn btn-flat pull-left m-8 btn-sm mt-10 btn-warning">
        <strong><i class="fa fa-th-large"></i> &nbsp; @lang('sale.pos_sale')</strong>
      </a>
      @endcan
      @endif

      @if(Module::has('Repair'))
      @includeIf('repair::layouts.partials.header')
      @endif
      <!--
        @can('profit_loss_report.view')
          <button type="button" id="view_todays_profit" title="{{ __('home.todays_profit') }}" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 btn-sm mt-10">
            <strong><i class="fas fa-money-bill-alt fa-lg"></i></strong>
          </button>
        @endcan
        -->
      <ul class="nav navbar-nav">
        @include('layouts.partials.header-notifications')
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            @php
            $profile_photo = auth()->user()->media;
            @endphp
            @if(!empty($profile_photo))
            <img src="{{$profile_photo->display_url}}" class="user-image" alt="User Image">
            @endif
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span>{{ Auth::User()->first_name }} {{ Auth::User()->last_name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              @if(!empty(Session::get('business.logo')))
              <img src="{{ asset( 'uploads/business_logos/' . Session::get('business.logo') ) }}" alt="Logo">
              @endif
              <p>
                {{ Auth::User()->first_name }} {{ Auth::User()->last_name }}
              </p>
            </li>
            <!-- Menu Body -->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{action([\App\Http\Controllers\UserController::class, 'getProfile'])}}"
                  class="btn btn-default btn-flat">@lang('lang_v1.profile')</a>
              </div>
              <div class="pull-right">
                <a href="{{action([\App\Http\Controllers\Auth\LoginController::class, 'logout'])}}"
                  class="btn btn-default btn-flat">@lang('lang_v1.sign_out')</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
      </ul>
    </div>
  </nav>
</header>