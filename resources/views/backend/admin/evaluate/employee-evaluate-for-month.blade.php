@extends('backend/layouts/admin/template')
<link type="text/css" href="{{ asset('assets/css/accordion.css') }}" rel="stylesheet">
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-body" style="text-align: center;">
                <h3>ผลการประเมินพนักงาน</h3>
                @php
                    $position = DB::table('positions')
                        ->where('id', $employee->position_id)
                        ->value('position');
                @endphp
                <h4>{{ $employee->name }} {{ $employee->surname }} ({{ $employee->nickname }}) ตำแหน่ง {{ $position }}
                </h4>
                <hr class="my-0" />
                <div class="accordion">
                    <div class="row">
                        @foreach ($years as $year => $value)
                            <div class="col-md-3 mt-3">
                                <a href="{{ url('/admin/evaluate-detail') }}/{{ $id }}/{{ $value->year }}"
                                    class="btn btn-success">ผลการประเมินประจำปี {{ $value->year }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- @foreach ($years as $year => $value)
                        <div class="col-md-3 mt-3">
                            <a href="" class="btn btn-success">ผลการประเมินประจำปี {{ $value->year }}</a>
                        </div>
                    @endforeach --}}
                {{-- @foreach ($amounts as $amount => $value)
                        <div class="col-md-3 mt-3">
                            <a href="" class="btn btn-success">ผลการประเมินประจำปี {{$amount+1}}</a>
                        </div>
                    @endforeach --}}
            </div>
        </div>
    </div>
@endsection
