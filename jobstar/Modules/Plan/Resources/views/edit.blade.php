@extends('admin.layouts.app')
@section('title')
    {{ __('edit') }}
@endsection
@section('content')
    @if (userCan('plan.update'))
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title line-height-36">{{ __('edit') }} {{ __('plan') }}</h3>
                            <a href="{{ route('module.plan.index') }}"
                                class="btn bg-primary float-right d-flex align-items-center justify-content-center">
                                <i class="fas fa-arrow-left"></i>&nbsp; {{ __('back') }}
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <form action="{{ route('module.plan.update', $plan->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="label">{{ __('label') }} <small
                                                            class="text-danger">*</small></label>
                                                    <input type="text" id="label" name="label" value="{{ $plan->label }}"
                                                        class="form-control @error('label') is-invalid @enderror"
                                                        placeholder="{{ __('basic_standard_premium') }}">
                                                    @error('label')
                                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="price">{{ __('price') }}
                                                        {{ defaultCurrencySymbol() }}<small
                                                            class="text-danger">*</small></label>
                                                    <input type="number" id="price" name="price" value="{{ $plan->price }}"
                                                        class="form-control @error('price') is-invalid @enderror">
                                                    @error('price')
                                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="job_limit">{{ __('job_limit') }} <small
                                                            class="text-danger">*</small></label>
                                                    <input type="number" id="job_limit" name="job_limit"
                                                        value="{{ $plan->job_limit }}"
                                                        class="form-control @error('job_limit') is-invalid @enderror"
                                                        placeholder="{{ __('enter') }} {{ __('job_limit') }}">
                                                    @error('job_limit')
                                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="featured_job_limit">{{ __('featured_job_limit') }} <small
                                                            class="text-danger">*</small></label>
                                                    <input type="number" id="featured_job_limit" name="featured_job_limit"
                                                        value="{{ $plan->featured_job_limit ?? old('featured_job_limit') }}"
                                                        class="form-control @error('featured_job_limit') is-invalid @enderror"
                                                        placeholder="{{ __('enter') }} {{ __('featured_job_limit') }}">
                                                    @error('featured_job_limit')
                                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="highlight_job_limit">{{ __('highlight_job_limit') }} <small
                                                            class="text-danger">*</small></label>
                                                    <input type="number" id="highlight_job_limit" name="highlight_job_limit"
                                                        value="{{ $plan->highlight_job_limit ?? old('highlight_job_limit') }}"
                                                        class="form-control @error('highlight_job_limit') is-invalid @enderror"
                                                        placeholder="{{ __('enter') }} {{ __('highlight_job_limit') }}">
                                                    @error('highlight_job_limit')
                                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="highlight_job_limit">
                                                        {{ __('candidate_profile_view_limitation') }} <small class="text-danger">*</small>
                                                    </label> <br>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input {{ old('candidate_cv_view_limitation',$plan->candidate_cv_view_limitation) == 'limited' ? 'checked':'' }} type="radio" id="limited_profile_view" name="candidate_cv_view_limitation" class="candidate_profile_view custom-control-input" value="limited">
                                                        <label class="custom-control-label" for="limited_profile_view">{{ __('limited') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input {{ old('candidate_cv_view_limitation',$plan->candidate_cv_view_limitation) == 'unlimited' ? 'checked':'' }} type="radio" id="unlimited_profile_view" name="candidate_cv_view_limitation" class="candidate_profile_view custom-control-input" value="unlimited">
                                                        <label class="custom-control-label" for="unlimited_profile_view">
                                                            {{ __('unlimited') }}
                                                        </label>
                                                    </div>
                                                    @error('candidate_cv_view_limitation')
                                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="candidate_profile_view_count_field">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="candidate_cv_preview_limit">{{ __('candidate_cv_preview_limit') }}
                                                        <small class="text-danger">*</small></label>
                                                    <input type="number" id="candidate_cv_preview_limit" name="candidate_cv_view_limit" value="{{ old('candidate_cv_view_limit', $plan->candidate_cv_view_limit) }}" class="form-control @error('candidate_cv_view_limit') is-invalid @enderror"
                                                        placeholder="{{ __('enter') }} {{ __('candidate_cv_preview_limit') }}" min="0">
                                                    @error('candidate_cv_view_limit')
                                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="frontend_show">
                                                        {{ __('show_frontend') }} <small class="text-danger">*</small>
                                                    </label> <br>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="show_frontend_yes" name="frontend_show" class="plan_type_selection custom-control-input" value="1" {{ $plan->frontend_show ? 'checked':'' }}>
                                                        <label class="custom-control-label" for="show_frontend_yes">{{ __('yes') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="show_frontend_no" name="frontend_show" class="plan_type_selection custom-control-input" value="0" {{ !$plan->frontend_show ? 'checked':'' }}>
                                                        <label class="custom-control-label" for="show_frontend_no">
                                                            {{ __('no') }}
                                                        </label>
                                                    </div>
                                                    @error('frontend_show')
                                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="candidate_profile_view_count_field">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="candidate_cv_preview_limit">{{ __('Days') }}
                                                        <small class="text-danger">*</small></label>
                                                    <input type="number" id="days"
                                                        name="days"
                                                        value="{{ $plan->days ?? old('days') }}"
                                                        class="form-control @error('days') is-invalid @enderror"
                                                        placeholder="{{ __('enter') }} {{ __('No of Days') }}" min="0">
                                                    @error('No of Days')
                                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="description">{{ __('description') }}
                                                    </label>
                                                    <textarea name="description" placeholder="{{ __('description') }}"
                                                        class="form-control @error('description') is-invalid @enderror"
                                                        id="description" cols="1"
                                                        rows="4">{{ $plan->description }}</textarea>
                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <button class="btn btn-success" type="submit">
                                                <i class="fas fa-sync"></i>&nbsp; {{ __('update') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


@section('script')
    <script>
        checkSubscriptionType('{{ old("subscription_type", $plan->subscription_type) }}');

        $('.plan_type_selection').on('click', function(value){
            var value = $("[name='subscription_type']:checked").val();
            checkSubscriptionType(this.value);
        });

        function checkSubscriptionType(type){
            if (type == 'recurring') {
                $('#plan_interval').removeClass('d-none');
            }else{
                $('#plan_interval').addClass('d-none');
            }
        }

        profileViewLimitation('{{ old("candidate_cv_view_limitation", $plan->candidate_cv_view_limitation) }}');

        function profileViewLimitation(status){
            if (status == 'unlimited') {
                $('#candidate_profile_view_count_field').addClass('d-none');
            }else{
                $('#candidate_profile_view_count_field').removeClass('d-none');
            }
        }

        $('.candidate_profile_view').on('click', function(value){
            var value = $("[name='candidate_cv_view_limitation']:checked").val();
            profileViewLimitation(this.value);
        });
    </script>
@endsection
