<div class="object-images-wrapper">
    <a href="#" class="add-new-object-image js-btn-trigger-add-image"
       data-name="images[]">{{ trans('plugins/real-estate::property.form.button_add_image') }}
    </a>
    @php $object_images = old('images', !empty($object) ? $object->images : null); @endphp
    <div class="images-wrapper">
        <div data-name="images[]" class="text-center cursor-pointer js-btn-trigger-add-image default-placeholder-object-image @if (is_array($object_images) && !empty($object_images)) hidden @endif">
            <img src="{{ url('vendor/core/images/placeholder.png') }}" alt="{{ __('Image') }}" width="120">
            <br>
            <p style="color:#c3cfd8">{{ __('Sử dụng nút') }} <strong>{{ __('Chọn hình') }}</strong> {{ __('để thêm hình') }}.</p>
        </div>
        <ul class="list-unstyled list-gallery-media-images clearfix @if (!is_array($object_images) || empty($object_images)) hidden @endif" style="padding-top: 20px;">
            @if (is_array($object_images) && !empty($object_images))
                @foreach($object_images as $image)
                    <li class="object-image-item-handler">
                        @include('plugins/real-estate::partials.components.image', [
                            'name' => 'images[]',
                            'value' => $image
                        ])
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>

<script id="object_select_image_template" type="text/x-custom-template">
    @include('plugins/real-estate::partials.components.image', [
        'name' => '__name__',
        'value' => null
    ])
</script>
