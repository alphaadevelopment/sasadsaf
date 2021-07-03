  @extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'basic'])

@section('title')
  Statistics Overview
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-tachometer-alt"></i>
        <ul class="list list-unstyled">
            <li><h1>Statistics Overview</h1></li>
            <li><small>View panel usage.</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Admin</a></li>
            <li class="breadcrumb-item active">Statistics Overview</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Egg</h5>
              <span class="h2 font-weight-bold mb-0">{{ $eggsCount }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                <i class="fas fa-box"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Users</h5>
              <span class="h2 font-weight-bold mb-0">{{ $usersCount }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                <i class="fas fa-users"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Nodes</h5>
              <span class="h2 font-weight-bold mb-0">{{ count($nodes) }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                <i class="fas fa-chart-pie"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Databases</h5>
              <span class="h2 font-weight-bold mb-0">{{ $databasesCount }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                <i class="fas fa-database"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">Servers</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <canvas id="servers_chart" width="100%" height="70"></canvas>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <canvas id="status_chart" width="100%" height="70"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <a class="btn btn-md btn-primary btn-block text-left">Servers <span class="float-right">{{ count($servers) }}</span></a>
                    </div>
                    <div class="col-md-12 mb-2">
                        <a class="btn btn-md btn-primary btn-block text-left">Total used Memory (in MB) <span class="float-right">{{ $totalServerRam }} MB</span></a>
                    </div>
                    <div class="col-md-12">
                        <a class="btn btn-md btn-primary btn-block text-left">Total used Disk (in MB) <span class="float-right">{{ $totalServerDisk }} MB</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Nodes</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <canvas id="ram_chart" width="100%" height="70"></canvas>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <canvas id="disk_chart" width="100%" height="70"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <a class="btn btn-md btn-primary btn-block text-left">Total RAM <span class="float-right">{{ $totalNodeRam }} MB</span></a>
                    </div>
                    <div class="col-md-12 mb-2">
                        <a class="btn btn-md btn-primary btn-block text-left">Total Disk Space <span class="float-right">{{ $totalNodeDisk }} MB</span></a>
                    </div>
                    <div class="col-md-12">
                        <a class="btn btn-md btn-primary btn-block text-left">Total Allocations <span class="float-right">{{ $totalAllocations }}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/chartjs/chart.min.js') !!}
    {!! Theme::js('js/admin/statistics.js') !!}
@endsection