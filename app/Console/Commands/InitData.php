<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use App\Models\Banner;
use App\Models\BannerCategory;
use Illuminate\Support\Facades\Storage;
use File;

class InitData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'default data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->initMobileData();
        $this->initPCData();
        $this->initCategoryData();
        return 0;
    }

    private function initMobileData()
    {
        echo PHP_EOL;
        $index = BannerCategory::where('type', 'image_mobile_index')->first();
        if ($index) {
            $index->category_title = "모바일-인덱스 헤더이미지";
            $index->save();
            echo "update banner index", PHP_EOL;
        } else {
            $index = BannerCategory::create([
                'category_title' => '모바일-인덱스 헤더이미지',
                'type' => 'image_mobile_index',
                'width' => '600',
                'height' => '200',
                'resize' => 'N',
            ]);
            echo "make banner index", PHP_EOL;
        }
        $indesbanner = Banner::where('banner_category_id', $index->id)->first();

        if (empty($indesbanner->id)) {
            File::copy(public_path() . '/image/bg-logo-poster.png', storage_path() . '/app/public/default.png');
            $banner = Banner::create([
                'alt' => 'WAY2EXPO',
                'url' => '/',
                'image_url' => 'default.png',
                'image_path' => 'default.png',
                'banner_class' => 'none',
                'active' => '1',
                'banner_category_id' => $index->id,
                'views' => '0',
                'clicks' => '0'
            ]);
        }
        echo PHP_EOL;

        $index = BannerCategory::where('type', 'mobile_main_header')->first();
        if ($index) {
            $index->category_title = "모바일-메인 배너 헤더";
            $index->save();
        } else {
            $index = BannerCategory::create([
                'category_title' => '모바일-메인 배너 헤더',
                'type' => 'mobile_main_header', 'width' => '600', 'height' => '200', 'resize' => 'Y',
            ]);
        }
        $index = BannerCategory::where('type', 'expo_main_header')->first();
        if ($index) {
            $index->category_title = "모바일-엑스포 배너 헤더";
            $index->save();
        } else {
            $index = BannerCategory::create([
                'category_title' => '모바일-엑스포 배너 헤더',
                'type' => 'expo_main_header', 'width' => '600', 'height' => '200', 'resize' => 'Y',
            ]);
        }
        $index = BannerCategory::where('type', 'm_expo_booth_head')->first();
        if ($index) {
            $index->category_title = "모바일-부스 배너 헤더";
            $index->save();
        } else {
            $index = BannerCategory::create([
                'category_title' => '모바일-부스 배너 헤더',
                'type' => 'm_expo_booth_head', 'width' => '600', 'height' => '200', 'resize' => 'Y',
            ]);
        }
    }

    private function initPCData()
    {
        echo PHP_EOL;
        $index = BannerCategory::where('type', 'image_pc_index')->first();
        if ($index) {
            $index->category_title = "PC-인덱스 헤더이미지";
            $index->save();
            echo "update banner index", PHP_EOL;
        } else {
            $index = BannerCategory::create([
                'category_title' => 'PC-인덱스 헤더이미지',
                'type' => 'image_pc_index',
                'width' => '1024',
                'height' => '300',
                'resize' => 'N',
            ]);
            echo "make banner index", PHP_EOL;
        }
        $indexbanner = Banner::where('banner_category_id', $index->id)->first();

        if (empty($indexbanner->id)) {
            File::copy(public_path() . '/image/bg-logo-poster.png', storage_path() . '/app/public/default.png');
            $banner = Banner::create([
                'alt' => 'WAY2EXPO',
                'url' => '/',
                'image_url' => 'default.png',
                'image_path' => 'default.png',
                'banner_class' => 'none',
                'active' => '1',
                'banner_category_id' => $index->id,
                'views' => '0',
                'clicks' => '0'
            ]);
        }
        echo PHP_EOL;

        $index = BannerCategory::where('type', 'pc_main_header')->first();
        if ($index) {
            $index->category_title = "PC-메인 배너 헤더";
            $index->save();
        } else {
            $index = BannerCategory::create([
                'category_title' => 'PC-메인 배너 헤더',
                'type' => 'pc_main_header', 'width' => '1024', 'height' => '300', 'resize' => 'Y',
            ]);
        }
        $index = BannerCategory::where('type', 'pc_expo_main_header')->first();
        if ($index) {
            $index->category_title = "PC-엑스포 배너 헤더";
            $index->save();
        } else {
            $index = BannerCategory::create([
                'category_title' => 'PC-엑스포 배너 헤더',
                'type' => 'pc_expo_main_header', 'width' => '1024', 'height' => '300', 'resize' => 'Y',
            ]);
        }
        $index = BannerCategory::where('type', 'pc_expo_detail_header')->first();
        if ($index) {
            $index->category_title = "PC-박람회_상세_부스_프로모션배너";
            $index->save();
        } else {
            $index = BannerCategory::create([
                'category_title' => 'PC-박람회_상세_부스_프로모션배너',
                'type' => 'pc_expo_detail_header', 'width' => '1024', 'height' => '300', 'resize' => 'Y',
            ]);
        }
        $index = BannerCategory::where('type', 'pc_expo_booth_head')->first();
        if ($index) {
            $index->category_title = "PC-부스 배너 헤더";
            $index->save();
        } else {
            $index = BannerCategory::create([
                'category_title' => 'PC-부스 배너 헤더',
                'type' => 'pc_expo_booth_head', 'width' => '1024', 'height' => '300', 'resize' => 'Y',
            ]);
        }
        return 0;
    }

    private function initCategoryData()
    {
        echo PHP_EOL;
        $category = Category::all();
        if ($category->count() < 1) {
            $data = [
                [
                    'name' => '뷰티',
                    'child' => [
                        '화장품',
                        '헤어',
                        '네일',
                        '발관리',
                        '에스테틱',
                        '왁싱,타투',
                        '비만,성형',
                        '헬스,스파',
                        '이너뷰티',
                        '바디케어',
                        '원재료',
                        '코스메슈티컬',
                        '미용체인',
                        '의료서비스',
                        '기타 뷰티 관련',
                    ],
                ],
                [
                    'name' => '펫',
                    'child' => [
                        '펫 푸드',
                        '펫 헬스케어',
                        '펫 용품',
                        '이동용품(이동장,유모차)',
                        '펫 의류',
                        '캣타워, 휠, 스크래쳐',
                        '목욕, 위생',
                        '펫 서비스(미용, 탁묘, 장례, 의료 등)',
                        '기타 펫 관련',
                    ]
                ],
                [
                    'name' => '카페',
                    'child' => [
                        '커피',
                        '차',
                        '베이커리',
                        '머신',
                        '디저트',
                        '아이스크림',
                        '초콜릿',
                        '음료, 주류',
                        '원부재료',
                        '카페용품',
                        '장비, 설비',
                        '인테리어',
                        '프랜차이즈',
                        '주방가전',
                        '외식산업',
                        '기타 카페 관련',
                    ]
                ],
                [
                    'name' => '비건',
                    'child' => [
                        '비건 식재료',
                        '비건 베이커리',
                        '비건 샐러드',
                        '비건 디저트',
                        '비건 레스토랑',
                        '비건 뷰티, 패션',
                        '비건 생활용품',
                        '템플푸드',
                        '비건산업 기자재, 식품기기',
                        '기타 비건 관련',
                    ]
                ],
                [
                    'name' => '캠핑',
                    'child' => [
                        '텐트 및 타프',
                        '캠핑카, 카라반',
                        '캠핑 트레일러',
                        '차량용 텐트',
                        '취사, 조명기구',
                        '캠핑 용품',
                        '아웃도어 의류',
                        '아웃도어 용품',
                        '기타 캠핑 관련',
                    ]
                ],

            ];
            echo "make category", PHP_EOL;
            $code1 = 'A';
            foreach ($data as $item) {
                $parent = new Category([
                    'code1' => $code1,
                    'code2' => 0,
                    'full_code' => (string)$code1 . sprintf("%02d", 0),
                    'name' => $item['name'],
                    'parent_id' => 0,
                    'display_yn' => 'Y',
                ]);
                $parent->save();
                $i = 1;
                foreach ($item['child'] as $child) {
                    $child = new Category([
                        'code1' => $parent->code1,
                        'code2' => $i,
                        'full_code' => $parent->code1 . sprintf("%02d", $i),
                        'name' => $child,
                        'parent_id' => $parent->id,
                        'display_yn' => 'Y',
                    ]);
                    $child->save();
                    $i++;
                }
                ++$code1;
            }
            echo "complete make category", PHP_EOL;

        } else {
            echo "not empty category", PHP_EOL;
        }
    }
}
