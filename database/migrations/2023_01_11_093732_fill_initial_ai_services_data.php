<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai_services', function (Blueprint $table) {
            $values = [
                ['name' => 'Midjourney', 'url' => 'https://midjourney.com/home/'],
                ['name' => 'DALL-E 2', 'url' => 'https://openai.com/dall-e-2/'],
                ['name' => 'NightCafe', 'url' => 'https://nightcafe.studio/'],
                ['name' => 'starryai', 'url' => 'https://starryai.com/'],
                ['name' => 'Wombo Dream', 'url' => 'https://dream.ai/'],
                ['name' => 'Deep Dream Generator', 'url' => 'https://deepdreamgenerator.com/'],
                ['name' => 'Deep AI', 'url' => 'https://deepai.org/'],
                ['name' => 'pixray', 'url' => 'https://pixray.gob.io/'],
                ['name' => 'Stable Diffusion', 'url' => 'https://stablediffusionweb.com/'],
                ['name' => 'Big Sleep', 'url' => 'https://github.com/lucidrains/big-sleep'],
                ['name' => 'Artbreeder', 'url' => 'https://www.artbreeder.com/'],
                ['name' => 'Craiyon', 'url' => 'https://www.craiyon.com/'],
                ['name' => 'fotor', 'url' => 'https://www.fotor.com/features/ai-image-generator/'],
            ];
            DB::table('ai_services')->insert($values);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ai_services', function (Blueprint $table) {
            Schema::table('ai_services')->truncate();
        });
    }
};
