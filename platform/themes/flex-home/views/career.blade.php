<div class="bgheadproject hidden-xs">
    <div class="description">
        <div class="container-fluid w90">
        </div>
    </div>
</div>
<div class="container padtop50">
            <h1 class="text-center">{{ __('Careers') }}</h1>
            {!! Theme::partial('breadcrumb') !!}
    <div class="row">
        <div class="col-sm-9">
            <h2 class="titlenews">{{ $career->name }}</h2>
            <div class="job-list">
                <div class="job-item">
                    <div class="job-header"><p><strong>{{ __('Location') }}:</strong>&nbsp;{{ $career->location }}</p>
                        <p><strong>{{ __('Salary') }}:</strong>&nbsp;{{ $career->salary }}</p>
                        <p><strong>{{ __('Posted at') }}:</strong>&nbsp;{{ $career->created_at->format('Y-m-d') }}</p></div>
                    <div class="job-content">
                        {!! $career->description !!}
                    </div>
                </div>
            </div>
            {!! Theme::partial('uploadfiles') !!}
        </div>
        <div class="col-sm-3">
        <!-- {!! Theme::partial('sidebar') !!} -->
        </div>
       
    </div>
</div>
<br>
<br>
