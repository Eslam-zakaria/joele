<?php

namespace Modules\Setting\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\UploaderService;
use App\Services\SettingsServices;
use App\Services\Sitemap\CreateSitemapService;
use Illuminate\Support\Facades\Schema;
use Modules\Setting\Http\Requests\SettingsRequest;
use Modules\Setting\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingsServices;

    public function __construct(SettingsServices $settingsServices)
    {
        $this->settingsServices = $settingsServices;
    }

    public function index()
    {
        $settings = $this->settingsServices->list();

        return view('Setting.Resources.views.index', compact('settings'));
    }

    public function update(SettingsRequest $request)
    {
        $this->settingsServices->update($request->except('_method', '_token'));

        return redirect()->route('admin.settings.index')->with(['success' => 'Updated Successfully']);
    }

    /**
     * Call sitemap services.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \DOMException
     */
    public function site_map()
    {
        # Services to generate sitemap.
        app(CreateSitemapService::class)->create();

        return redirect()->route('admin.settings.index')->with('success', 'site map file generated successfully');
    }
}

