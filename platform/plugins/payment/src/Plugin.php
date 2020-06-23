<?php

namespace Botble\Payment;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('subscriptions');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('stripe_id');
            $table->dropColumn('card_brand');
            $table->dropColumn('card_last_four');
            $table->dropColumn('trial_ends_at');
        });
    }
}
