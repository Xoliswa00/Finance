@extends('layouts.Admin')
@section('page-title', 'Platform Health')
@section('content')

<div class="container-fluid py-2">

  {{-- ── Health checks ───────────────────────────────────────────── --}}
  <div class="row g-3 mb-4">
    @foreach($checks as $check)
    @php
      $icon  = $check['status'] === 'ok' ? 'check_circle' : ($check['status'] === 'warn' ? 'warning' : 'error');
      $color = $check['status'] === 'ok' ? 'success'      : ($check['status'] === 'warn' ? 'warning'  : 'danger');
    @endphp
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="d-flex align-items-center">
            <div class="icon icon-shape bg-gradient-{{ $color }} shadow-{{ $color }} border-radius-md me-3" style="width:44px;height:44px;display:flex;align-items:center;justify-content:center;">
              <i class="material-icons text-white opacity-10">{{ $icon }}</i>
            </div>
            <div>
              <p class="text-xs text-secondary mb-0">{{ $check['label'] }}</p>
              <h6 class="mb-0 text-sm">{{ $check['value'] }}</h6>
              @if(!empty($check['note']))
                <p class="text-xxs text-warning mb-0">{{ $check['note'] }}</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- ── Table row counts ────────────────────────────────────────── --}}
  <div class="row g-3 mb-4">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header pb-0">
          <h6 class="mb-0">Database Table Sizes</h6>
        </div>
        <div class="card-body px-0 pb-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Table</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-end">Rows</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tables as $table => $count)
              <tr>
                <td><p class="text-xs font-weight-bold mb-0">{{ $table }}</p></td>
                <td class="text-end"><span class="text-xs text-secondary">{{ is_numeric($count) ? number_format($count) : $count }}</span></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- ── Error log ──────────────────────────────────────────────── --}}
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Error Log <span class="text-secondary text-xs">(last 100 lines, newest first)</span></h6>
        </div>
        <div class="card-body p-0">
          <div style="background:#0f172a;border-radius:0 0 12px 12px;max-height:500px;overflow-y:auto;font-family:monospace;font-size:.72rem;padding:16px;">
            @if(empty($logLines))
              <span style="color:#64748b;">No log file found or log is empty.</span>
            @else
              @foreach($logLines as $line)
                @php
                  $isError = str_contains($line, '.ERROR') || str_contains($line, 'CRITICAL') || str_contains($line, 'ALERT');
                  $isWarn  = str_contains($line, '.WARNING') || str_contains($line, '.NOTICE');
                  $color   = $isError ? '#f87171' : ($isWarn ? '#fbbf24' : '#94a3b8');
                @endphp
                <div style="color:{{ $color }};border-bottom:1px solid rgba(255,255,255,.04);padding:2px 0;">{{ htmlspecialchars($line) }}</div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
