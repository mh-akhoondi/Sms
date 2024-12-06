<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Sms\Entities\SmsSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Module::validateVersion(SmsSetting::MODULE_NAME);

        Schema::create('sms_settings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('account_sid')->nullable();
            $table->string('auth_token')->nullable();
            $table->string('from_number')->nullable();
            $table->boolean('status');
            $table->string('admin_from_number')->nullable();
            $table->boolean('admin_status');

            $table->string('nexmo_api_key')->nullable();
            $table->string('nexmo_api_secret')->nullable();
            $table->string('nexmo_from_number')->nullable();
            $table->boolean('nexmo_status');

            $table->string('msg91_auth_key')->nullable();
            $table->string('msg91_from')->nullable();
            $table->boolean('msg91_status');

            $table->string('provider'); // نام درایور، مثلا 'farazsms'
            $table->string('userid');
            $table->string('password');
            $table->string('from');
            $table->string('adminnumber');
            $table->boolean('itn_status');

            $table->string('purchase_code')->nullable();
            $table->string('username', 80)->nullable();
            $table->timestamp('supported_until')->nullable();
            $table->timestamps();
        });

        SmsSetting::create([]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_settings');
    }
};
