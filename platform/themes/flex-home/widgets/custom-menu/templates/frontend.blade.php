<div class="col-sm-4">
    <div class="menufooter">
        <h4>{{ __($config['name']) }}</h4>
        {!!
            Menu::generateMenu(['slug' => $config['menu_id']])
        !!}
    </div>
</div>
