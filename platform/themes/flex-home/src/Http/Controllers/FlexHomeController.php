<?php

namespace Theme\FlexHome\Http\Controllers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\Career\Models\Career;
use Botble\Career\Repositories\Interfaces\CareerInterface;
use Botble\Location\Repositories\Interfaces\CityInterface;
use Botble\Page\Repositories\Interfaces\PageInterface;
use Botble\RealEstate\Enums\ProjectStatusEnum;
use Botble\RealEstate\Enums\PropertyStatusEnum;
use Botble\RealEstate\Enums\PropertyTypeEnum;
use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Models\Property;
use Botble\RealEstate\Repositories\Interfaces\CategoryInterface;
use Botble\RealEstate\Repositories\Interfaces\ProjectInterface;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use Botble\SeoHelper\SeoOpenGraph;
use Botble\Slug\Repositories\Interfaces\SlugInterface;
use Botble\Theme\Events\RenderingHomePageEvent;
use Botble\Theme\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SeoHelper;
use SlugHelper;
use Theme;
use Theme\FlexHome\Http\Resources\PostResource;
use Theme\FlexHome\Http\Resources\PropertyResource;

class FlexHomeController extends PublicController
{
    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getIndex(BaseHttpResponse $response)
    {
        $homepage = $this->settingStore->get('show_on_front');
        if ($homepage) {
            $homepage = app(PageInterface::class)->findById($homepage);
            if ($homepage) {
                return $this->getView($response, $homepage->slug);
            }
        }

        Theme::breadcrumb()->add(__('Home'), url('/'));

        event(RenderingHomePageEvent::class);

        $projects = collect([]);

        if (is_plugin_active('real-estate')) {
            $projects = app(ProjectInterface::class)->advancedGet([
                'condition' => [
                    're_projects.is_featured' => true,
                    're_projects.status'      => ProjectStatusEnum::SELLING,
                ],
                'take'      => theme_option('number_of_featured_projects', 4),
                'with'      => ['currency'],
            ]);
        }

        $cities = collect([]);

        if (is_plugin_active('location')) {
            $cities = app(CityInterface::class)->advancedGet([
                'condition' => [
                    'cities.is_featured' => true,
                    'cities.status'      => BaseStatusEnum::PUBLISHED,
                ],
                'take'      => theme_option('number_of_featured_cities', 10),
            ]);
        }

        return Theme::scope('index', compact('projects', 'cities'))->render();
    }

    /**
     * @param BaseHttpResponse $response
     * @param null $key
     * @return BaseHttpResponse|\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getView(BaseHttpResponse $response, $key = null)
    {
        return parent::getView($response, $key);
    }

    /**
     * @return mixed
     */
    public function getSiteMap()
    {
        return parent::getSiteMap();
    }

    /**
     * @param string $key
     * @param SlugInterface $slugRepository
     * @param ProjectInterface $projectRepository
     * @return \Illuminate\Http\Response|\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getProject(string $key, SlugInterface $slugRepository, ProjectInterface $projectRepository)
    {
        $slug = $slugRepository->getFirstBy(['slugs.key' => $key, 'prefix' => SlugHelper::getPrefix(Project::class)]);

        if (!$slug) {
            abort(404);
        }

        $project = $projectRepository->getFirstBy([
            'id' => $slug->reference_id,
        ], ['*'], ['features', 'currency', 'category']);

        if (!$project) {
            abort(404);
        }

        SeoHelper::setTitle($project->name)->setDescription(Str::words($project->description, 120));

        $meta = new SeoOpenGraph;
        if ($project->image) {
            $meta->setImage(get_image_url($project->image));
        }
        $meta->setDescription($project->description);
        $meta->setUrl(route('public.project', $slug->key));
        $meta->setTitle($project->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add($project->name, route('public.project', $slug));

        $relatedProjects = $projectRepository->getRelatedProjects($project->id,
            theme_option('number_of_related_projects', 8));

        Theme::asset()->usePath()->add('validation-jquery-css',
            'libraries/jquery-validation/validationEngine.jquery.css');
        Theme::asset()->add('images-grid-css',
            'https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css');
        Theme::asset()->container('header')->add('images-grid-js',
            'https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js', ['jquery']);
        Theme::asset()->container('header')->usePath()->add('jquery-validationEngine-vi-js',
            'libraries/jquery-validation/jquery.validationEngine-vi.js', ['jquery']);
        Theme::asset()->container('header')->usePath()->add('jquery-validationEngine-js',
            'libraries/jquery-validation/jquery.validationEngine.js', ['jquery']);

        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, PROJECT_MODULE_SCREEN_NAME, $project);

        $images = [];
        foreach ($project->images as $image) {
            $images[] = get_object_image($image);
        }

        return Theme::scope('project', compact('project', 'images', 'relatedProjects'))->render();
    }

    /**
     * @param string $key
     * @param SlugInterface $slugRepository
     * @param PropertyInterface $propertyRepository
     * @return \Illuminate\Http\Response|\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getProperty(string $key, SlugInterface $slugRepository, PropertyInterface $propertyRepository)
    {
        $slug = $slugRepository->getFirstBy(['slugs.key' => $key, 'prefix' => SlugHelper::getPrefix(Property::class)]);

        if (!$slug) {
            abort(404);
        }

        $property = $propertyRepository->getFirstBy([
            'id' => $slug->reference_id,
        ], ['*'], ['features', 'project', 'currency', 'author', 'category']);

        if (!$property) {
            abort(404);
        }

        SeoHelper::setTitle($property->name)->setDescription(Str::words($property->description, 120));

        $meta = new SeoOpenGraph;
        if ($property->image) {
            $meta->setImage(get_image_url($property->image));
        }
        $meta->setDescription($property->description);
        $meta->setUrl(route('public.property', $slug->key));
        $meta->setTitle($property->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add($property->name, route('public.property', $slug));

        Theme::asset()->usePath()->add('validation-jquery-css',
            'libraries/jquery-validation/validationEngine.jquery.css');
        Theme::asset()->add('images-grid-css',
            'https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css');
        Theme::asset()->container('header')->add('images-grid-js',
            'https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js', ['jquery']);
        Theme::asset()->container('header')->usePath()->add('jquery-validationEngine-vi-js',
            'libraries/jquery-validation/jquery.validationEngine-vi.js', ['jquery']);
        Theme::asset()->container('header')->usePath()->add('jquery-validationEngine-js',
            'libraries/jquery-validation/jquery.validationEngine.js', ['jquery']);

        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, PROPERTY_MODULE_SCREEN_NAME, $property);

        $images = [];
        foreach ($property->images as $image) {
            $images[] = get_object_image($image);
        }

        return Theme::scope('property', compact('property', 'images'))->render();
    }

    /**
     * @param Request $request
     * @param ProjectInterface $projectRepository
     * @param CategoryInterface $categoryRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Response
     */
    public function getProjects(
        Request $request,
        ProjectInterface $projectRepository,
        CategoryInterface $categoryRepository,
        BaseHttpResponse $response
    )
    {
        SeoHelper::setTitle(__('Projects'));

        $filters = [
            'keyword'     => $request->input('k'),
            'blocks'      => $request->input('blocks'),
            'min_floor'   => $request->input('min_floor'),
            'max_floor'   => $request->input('max_floor'),
            'min_flat'    => $request->input('min_flat'),
            'max_flat'    => $request->input('max_flat'),
            'category_id' => $request->input('category_id'),
        ];

        $params = [
            'paginate' => [
                'per_page'      => theme_option('number_of_projects_per_page', 12),
                'current_paged' => $request->input('page', 1),
            ],
        ];

        $projects = $projectRepository->getProjects($filters, $params);

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Projects'), route('public.projects'));

        if ($request->ajax()) {
            return $response->setData(Theme::partial('search-suggestion', ['items' => $projects]));
        }

        $categories = $categoryRepository->pluck('re_categories.name', 're_categories.id');

        return Theme::scope('projects', compact('projects', 'categories'))->render();
    }

    /**
     * @param Request $request
     * @param PropertyInterface $propertyRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Response
     */
    public function getProperties(
        Request $request,
        PropertyInterface $propertyRepository,
        CategoryInterface $categoryRepository,
        BaseHttpResponse $response
    )
    {
        SeoHelper::setTitle(__('Properties'));

        $filters = [
            'keyword'     => $request->input('k'),
            'type'        => $request->input('type'),
            'bedroom'     => $request->input('bedroom'),
            'bathroom'    => $request->input('bathroom'),
            'floor'       => $request->input('floor'),
            'min_price'   => $request->input('min_price'),
            'max_price'   => $request->input('max_price'),
            'min_square'  => $request->input('min_square'),
            'max_square'  => $request->input('max_square'),
            'project'     => $request->input('project'),
            'category_id' => $request->input('category_id'),
        ];

        $params = [
            'paginate' => [
                'per_page'      => theme_option('number_of_properties_per_page', 12),
                'current_paged' => $request->input('page', 1),
            ],
        ];

        $properties = $propertyRepository->getProperties($filters, $params);

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Properties'), route('public.properties'));

        if ($request->ajax()) {
            return $response->setData(Theme::partial('search-suggestion', ['items' => $properties]));
        }

        $categories = $categoryRepository->pluck('re_categories.name', 're_categories.id');

        return Theme::scope('properties', compact('properties', 'categories'))->render();
    }

    /**
     * @return \Illuminate\Http\Response|\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function contact()
    {
        SeoHelper::setTitle(__('Contact'));

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Contact'), route('public.contact'));

        return Theme::scope('contact')->render();
    }

    public function blog()
    {
        SeoHelper::setTitle(__('Blog'));

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Blog'), route('public.blog'));

        return Theme::scope('blog')->render();
    }

    public function Historys()
    {
        SeoHelper::setTitle(__('Historys'));

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Historys'), route('public.historys'));

        return Theme::scope('historys')->render();
    }

    public function Teachers()
    {
        SeoHelper::setTitle(__('Teachers'));

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Teachers'), route('public.teachers'));

        return Theme::scope('teachers')->render();
    }

    public function Admissions()
    {
        SeoHelper::setTitle(__('Admissions'));

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Admissions'), route('public.admissions'));

        return Theme::scope('admissions')->render();
    }

    /**
     * @param CareerInterface $careerRepository
     * @return \Illuminate\Http\Response|\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function careers(CareerInterface $careerRepository)
    {
        SeoHelper::setTitle(__('Careers'));

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Careers'), route('public.careers'));

        $careers = $careerRepository->allBy(['status' => BaseStatusEnum::PUBLISHED]);

        return Theme::scope('careers', compact('careers'))->render();
    }

    /**
     * @param $key
     * @param CareerInterface $careerRepository
     * @param SlugInterface $slugRepository
     * @return \Illuminate\Http\Response|\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function career($key, CareerInterface $careerRepository, SlugInterface $slugRepository)
    {
        $slug = $slugRepository->getFirstBy(['key' => $key, 'prefix' => SlugHelper::getPrefix(Career::class)]);

        $career = $careerRepository->getFirstBy([
            'id'     => $slug->reference_id,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        SeoHelper::setTitle(__('Careers') . ' - ' . $career->name)
            ->setDescription(Str::limit($career->description, 120));

        $meta = new SeoOpenGraph;
        $meta->setDescription(Str::limit($career->description, 120));
        $meta->setUrl(route('public.career', $key));
        $meta->setTitle($career->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add($career->name, route('public.career', $key));

        return Theme::scope('career', compact('career'))->render();
    }

    /**
     * @param string $slug
     * @param Request $request
     * @param ProjectInterface $projectRepository
     * @param CategoryInterface $categoryRepository
     * @return \Response
     */
    public function getProjectsByCity(
        string $slug,
        Request $request,
        ProjectInterface $projectRepository,
        CategoryInterface $categoryRepository
    )
    {
        SeoHelper::setTitle(__('Projects'));

        $filters = [
            'city' => $slug,
        ];

        $params = [
            'paginate' => [
                'per_page'      => theme_option('number_of_projects_per_page', 12),
                'current_paged' => $request->input('page', 1),
            ],
        ];

        $projects = $projectRepository->getProjects($filters, $params);

        $categories = $categoryRepository->pluck('re_categories.name', 're_categories.id');

        return Theme::scope('projects', compact('projects', 'categories'))->render();
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetProperties(Request $request, BaseHttpResponse $response)
    {
        $properties = [];
        switch ($request->input('type')) {
            case 'related':
                $properties = app(PropertyInterface::class)
                    ->getRelatedProperties($request->input('property_id'),
                        theme_option('number_of_related_properties', 8));
                break;
            case 'rent':
                $properties = app(PropertyInterface::class)->advancedGet([
                    'condition' => [
                        're_properties.is_featured' => true,
                        're_properties.type'        => PropertyTypeEnum::RENT,
                        're_properties.status'      => PropertyStatusEnum::RENTING,
                    ],
                    'take'      => theme_option('number_of_properties_for_sell', 8),
                    'with'      => ['currency'],
                ]);
                break;
            case 'sale':
                $properties = app(PropertyInterface::class)->advancedGet([
                    'condition' => [
                        're_properties.is_featured' => true,
                        're_properties.type'        => PropertyTypeEnum::SALE,
                        're_properties.status'      => PropertyStatusEnum::SELLING,
                    ],
                    'take'      => theme_option('number_of_properties_for_sell', 8),
                    'with'      => ['currency'],
                ]);
                break;
            case 'project-properties-for-sell':
                $properties = app(PropertyInterface::class)->advancedGet([
                    'condition' => [
                        're_properties.project_id' => $request->input('project_id'),
                        're_properties.type'       => PropertyTypeEnum::SALE,
                        're_properties.status'     => PropertyStatusEnum::SELLING,
                    ],
                    'take'      => theme_option('number_of_properties_for_sell', 8),
                    'with'      => ['currency'],
                ]);
                break;
            case 'project-properties-for-rent':
                $properties = app(PropertyInterface::class)->advancedGet([
                    'condition' => [
                        're_properties.project_id' => $request->input('project_id'),
                        're_properties.type'       => PropertyTypeEnum::RENT,
                        're_properties.status'     => PropertyStatusEnum::RENTING,
                    ],
                    'take'      => theme_option('number_of_properties_for_sell', 8),
                    'with'      => ['currency'],
                ]);
                break;
        }

        return $response->setData(PropertyResource::collection($properties))
            ->toApiResponse();
    }

    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function ajaxGetPosts(BaseHttpResponse $response)
    {
        $posts = app(PostInterface::class)->getFeatured(4);

        return $response->setData(PostResource::collection($posts))
            ->toApiResponse();
    }
   
    public function fileUploadPost(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,docx,xlx,csv|max:2048',
        ]);
  
        $fileName = time().'.'.$request->file->extension();  
   
        $request->file->move(public_path('uploads'), $fileName);
   
        return back()
            ->with('success','You have successfully upload file.')
            ->with('file',$fileName);
   
    }
    public function Fees()
    {
        SeoHelper::setTitle(__('Fees'));

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Fees'), route('public.fees'));
        return Theme::scope('fees')->render();
    }
}
