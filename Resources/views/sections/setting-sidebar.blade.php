@if(user()->permission('manage_sms_settings') == 'all' && in_array(\Modules\Sms\Entities\SmsSetting::MODULE_NAME, user_modules()))
    @if (sms_setting()->license_type === "active" && sms_setting()->purchase_code != null)
        
    <x-setting-menu-item :active="$activeMenu" menu="sms_setting" :href="route('sms-setting.index')"
                         :text="__('sms::app.smsSetting')"/>
    @endif
@endif
