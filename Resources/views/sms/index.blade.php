@extends('layouts.app')
@if (sms_setting()->license_type === "active" && sms_setting()->purchase_code != null)
@section('content')

    <!-- SETTINGS START -->
    <div class="w-100 d-flex ">

        <x-setting-sidebar :activeMenu="$activeSettingMenu"/>

        <x-setting-card>
            <x-slot name="alert">
                <div class="row">
                    <div class="col-md-12">
                        <x-alert type="info" icon="info-circle">
                            @lang('sms::modules.gatewayLimitation')
                        </x-alert>
                    </div>
                    <div class="col-md-12">
                        <x-alert type="info" icon="info-circle">
                            @lang('sms::modules.mobileNumberFormat')
                        </x-alert>
                    </div>
                </div>
            </x-slot>

            <x-slot name="header">
                <div class="s-b-n-header" id="tabs">
                    <h2 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                        @lang($pageTitle)</h2>
                </div>
            </x-slot>

            <div class="col-xl-8 col-lg-12 col-md-12 ntfcn-tab-content-left w-100 py-4 ">
                <input type="hidden"
                       @if ($smsSetting->status)
                       value="IPPanel"                      
                       @elseif ($smsSetting->telegram_status)
                       value="telegram"
                       @endif
                       name="active_gateway" id="active_gateway">
                <div class="row">
                    <div class="col-md-10">
                        <h4 class="mb-4 f-21 font-weight-normal text-capitalize">
                            <img src="{{ asset('img/ippanel-logo.png') }}" width="100" alt="">
                        </h4>

                    </div>

                    <div class="col-lg-2 mb-2">
                        <div class="form-group text-right">
                            <div class="d-flex mt-2 justify-content-end">
                                <x-forms.checkbox fieldLabel=" " class="sms-gateway-status" fieldName="IPPanel-gateway"
                                                  fieldId="IPPanel-gateway" fieldValue="IPPanel"
                                                  :checked="$smsSetting->status"/>
                            </div>
                        </div>
                    </div>

                    <div id="IPPanel-form"
                         class="col-lg-12 @if (!$smsSetting->status) d-none @endif">
                        <div class="row">
                            <div class="col-6">
                                <x-forms.label class="mt-3" fieldId="account_sid" fieldLabel="نام کاربری"
                                               fieldRequired="true">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <input type="text" name="account_sid" id="account_sid"
                                           class="form-control height-35 f-14" value="{{ $smsSetting->account_sid }}">
                                </x-forms.input-group>
                            </div>
                            <div class="col-6">
                                <x-forms.label class="mt-3" fieldId="auth_token" fieldLabel="رمز عبور"
                                               fieldRequired="true">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <input type="password" name="auth_token" id="auth_token"
                                           class="form-control height-35 f-14" value="{{ $smsSetting->auth_token }}">

                                    <x-slot name="preappend">
                                        <button type="button" data-toggle="tooltip"
                                                data-original-title="Click Here to View Key"
                                                class="btn btn-outline-secondary border-grey height-35 toggle-password">
                                            <i
                                                class="fa fa-eye"></i></button>
                                    </x-slot>
                                </x-forms.input-group>
                            </div>
                            <div class="col-12">
                                <x-forms.tel fieldId="from_number" :fieldLabel="__('sms::app.fromNumber')"
                                             fieldName="from_number"
                                             fieldPlaceholder="e.g. 987654321"
                                             fieldRequired="true"
                                             :fieldValue="$smsSetting->from_number"></x-forms.tel>
                            </div>
                           <!-- <div class="col-6">
                                <div class="form-group my-3">
                                    <label class="f-14 text-dark-grey mb-12 w-100"
                                           for="admin_status1"><img src="{{ asset("img/whatsapp.svg") }}" width="20"
                                                                       alt=""> ارسال برای شماره دلخواه</label>
                                    <div class="d-flex">
                                        <x-forms.radio fieldId="admin_status1" :fieldLabel="__('app.enable')"
                                                       fieldName="admin_status"
                                                       fieldValue="1"
                                                       :checked="$smsSetting->admin_status == 1 || is_null($smsSetting->admin_status)">
                                        </x-forms.radio>
                                        <x-forms.radio fieldId="admin_status2" :fieldLabel="__('app.disable')"
                                                       fieldValue="0"
                                                       fieldName="admin_status"
                                                       :checked="$smsSetting->admin_status == 0"></x-forms.radio>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <x-forms.tel fieldId="whatapp_from_number"
                                             :fieldLabel="__('sms::app.fromNumber')"
                                             fieldName="whatapp_from_number"
                                             fieldPlaceholder="e.g. 987654321"
                                             fieldRequired="true"
                                             :fieldValue="$smsSetting->whatapp_from_number"></x-forms.tel>
                            </div> -->
                        </div>
                        <div class="row pb-3 @if (!$smsSetting->admin_status) d-none @endif"
                             id="whatsappTemplates">
                            @foreach ($smsSettings as $setting)
                                <div
                                    class="col-md-6 pt-3 whatsappTemplate{{$setting->id}} @if ($setting->send_sms == 'no') d-none @endif">
                                    <x-forms.label :fieldId="'whatsapp_'.$setting->id"
                                                   :fieldLabel="$setting->slug->label()"></x-forms.label>
                                    <a href="javascript:;" class="btn-copy btn-secondary f-12 rounded p-1 py-2 ml-1"
                                       data-clipboard-target="#whatsapp_template{{$setting->id}}"> <i
                                            class="fa fa-copy mx-1"></i></a>
                                    <textarea class="form-control f-14 pt-2" readonly rows="4"
                                              id="whatsapp_template{{$setting->id}}">{{ $setting->slug->whatsappTemplate() }}</textarea>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                
                <div class="row pt-2">
                    <div class="col-md-10">
                        <h4 class="mb-4 f-21 font-weight-normal text-capitalize text-dark-grey">
                            <img src="{{ asset('img/telegram.svg') }}" width="40" alt=""> Telegram
                        </h4>
                    </div>

                    <div class="col-lg-2 mb-2">
                        <div class="form-group text-right">
                            <div class="d-flex mt-2 justify-content-end">
                                <x-forms.checkbox fieldLabel=" " class="sms-gateway-status" fieldName="telegram"
                                                  fieldId="msg91-gateway" fieldValue="telegram"
                                                  :checked="$smsSetting->telegram_status"/>
                            </div>
                        </div>
                    </div>

                    <div id="telegram-form" class="col-lg-12 @if (!$smsSetting->telegram_status) d-none @endif">
                        <div class="row">
                            <div class="col-12">
                                <x-forms.label class="mt-3" fieldId="telegram_bot_token" :fieldLabel="__('sms::modules.telegramTelegramBotToken')"
                                               fieldRequired="true">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <input type="password" name="telegram_bot_token" id="telegram_bot_token"
                                           class="form-control height-35 f-14"
                                           value="{{ $smsSetting->telegram_bot_token }}">

                                    <x-slot name="preappend">
                                        <button type="button" data-toggle="tooltip"
                                                data-original-title="Click Here to View Key"
                                                class="btn btn-outline-secondary border-grey height-35 toggle-password">
                                            <i
                                                class="fa fa-eye"></i></button>
                                    </x-slot>
                                </x-forms.input-group>
                            </div>
                            <div class="col-12">
                                <x-forms.label class="mt-3" fieldId="telegram_bot_name" :fieldLabel="__('sms::modules.telegramTelegramBotName')"
                                               fieldRequired="true">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <input type="text" name="telegram_bot_name" id="telegram_bot_name"
                                           class="form-control height-35 f-14"
                                           value="{{ $smsSetting->telegram_bot_name }}">
                                </x-forms.input-group>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-md-12 ntfcn-tab-content-right border-left-grey px-4 pb-4 pt-2">
                <h4 class="f-16 text-capitalize f-w-500 text-dark-grey mb-5 mb-lg-0">
                    @lang("sms::app.notificationTitle") <br/>
                </h4>
                @foreach ($smsSettings as $setting)
                    <div class="mb-3 d-flex">
                        <x-forms.checkbox :checked="$setting->send_sms == 'yes'" class="send_sms"
                                          :fieldLabel="$setting->slug->label()"
                                          fieldName="send_sms[]" :fieldId="'send_sms_'.$setting->id"
                                          :fieldValue="$setting->id"/>
                    </div>
                @endforeach
            </div>

            <!-- Buttons Start -->
            <div class="w-100 border-top-grey">
                <div class="settings-btns py-3 d-lg-flex d-md-flex justify-content-end px-4">
                    <x-forms.button-secondary id="send-test-email" class="mr-3" icon="location-arrow">
                        @lang('sms::modules.sendTestMessage')</x-forms.button-secondary>
                    <x-forms.button-primary id="save-form" icon="check">@lang('app.save')</x-forms.button-primary>
                </div>
            </div>
            <!-- Buttons End -->

        </x-setting-card>

    </div>
    <!-- SETTINGS END -->

@endsection

@push('scripts')

    <script src="{{ asset('vendor/jquery/clipboard.min.js') }}"></script>
    <script>
        var clipboard = new ClipboardJS('.btn-copy');

        clipboard.on('success', function (e) {
            Swal.fire({
                icon: 'success',
                text: '@lang("app.smsTemplateCopied")',
                toast: true,
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                },
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
            })
        });

        @if ($smsSetting->admin_status == 0)
        $('#whatapp_from_number').attr('readonly', true);
        @endif

        $('input[name="admin_status"]').change(function () {
            let status = $(this).val();
            if (status == "0") {
                $("#whatapp_from_number").attr("readonly", true);
                $('#whatsappTemplates').addClass('d-none');
            } else {
                $("#whatapp_from_number").removeAttr("readonly");
                $('#whatsappTemplates').removeClass('d-none');
            }
        })
        $('#IPPanel-gateway, #nexmo-gateway, #msg91-gateway').change(function () {
            var gateway = $(this).val();

            $('#active_gateway').val('')
            if ($(this).is(':checked')) {
                console.log('#' + gateway + '-form');
                $('#' + gateway + '-form').removeClass('d-none');

                $('.sms-gateway-status').each(function (index) {
                    var switchStatus = $('.sms-gateway-status')[index].value;
                    var switchChecked = $('.sms-gateway-status')[index].checked;
                    if (gateway != switchStatus && switchChecked) {
                        $(this).trigger('click');
                    }
                });
                $('#active_gateway').val(gateway)

            } else {
                $('#' + gateway + '-form').addClass('d-none');
            }
        });

        $('#save-form').click(function () {
            var url = "{{ route('sms-setting.update', '1') }}";

            $.easyAjax({
                url: url,
                container: '#editSettings',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-form",
                data: $('#editSettings').serialize(),
            })
        });

        $('#send-test-email').click(function () {
            const url = "{{ route('sms-setting.test_message') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        $('.send_sms').change(function () {
            var status = $(this).is(':checked');
            var settingId = $(this).val();

            if (status) {
                $('input[name="msg91_flow_id[' + settingId + ']"]').removeAttr('disabled');
                $('.whatsappTemplate' + settingId).removeClass('d-none');
                $('.msg91Template' + settingId).removeClass('d-none');
            } else {
                $('input[name="msg91_flow_id[' + settingId + ']"]').attr('disabled', true);
                $('.whatsappTemplate' + settingId).addClass('d-none');
                $('.msg91Template' + settingId).addClass('d-none');
            }
        });

    </script>
@endpush
@endif