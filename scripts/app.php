<?php

const BASE_URL = 'https://wallpaperscraft.com/';
const LIMIT_IMAGES_EACH_PAGE = 100;
const CATEGORIES = [
    [
        'id' => 1,
        'name' => '3D',
        'link' => 'https://wallpaperscraft.com/catalog/3d',
        'path' => '3d'
    ],
    [
        'id' => 2,
        'name' => 'Abstract',
        'link' => 'https://wallpaperscraft.com/catalog/abstract',
        'path' => 'abstract'
    ],
    [
        'id' => 3,
        'name' => 'Animals',
        'link' => 'https://wallpaperscraft.com/catalog/animals',
        'path' => 'animals'
    ],
    [
        'id' => 4,
        'name' => 'Anime',
        'link' => 'https://wallpaperscraft.com/catalog/anime',
        'path' => 'anime'
    ],
    [
        'id' => 5,
        'name' => 'Art',
        'link' => 'https://wallpaperscraft.com/catalog/art',
        'path' => 'art'
    ],
    [
        'id' => 6,
        'name' => 'Black',
        'link' => 'https://wallpaperscraft.com/catalog/black',
        'path' => 'black'
    ],
    [
        'id' => 7,
        'name' => 'Black and white',
        'link' => 'https://wallpaperscraft.com/catalog/black_and_white',
        'path' => 'black_and_white'
    ],
    [
        'id' => 8,
        'name' => 'Cars',
        'link' => 'https://wallpaperscraft.com/catalog/cars',
        'path' => 'cars'
    ],
    [
        'id' => 9,
        'name' => 'City',
        'link' => 'https://wallpaperscraft.com/catalog/city',
        'path' => 'city'
    ],
    [
        'id' => 10,
        'name' => 'Dark',
        'link' => 'https://wallpaperscraft.com/catalog/dark',
        'path' => 'dark'
    ],
    [
        'id' => 11,
        'name' => 'Fantasy',
        'link' => 'https://wallpaperscraft.com/catalog/fantasy',
        'path' => 'fantasy'
    ],
    [
        'id' => 12,
        'name' => 'Flowers',
        'link' => 'https://wallpaperscraft.com/catalog/flowers',
        'path' => 'flowers'
    ],
    [
        'id' => 13,
        'name' => 'Food',
        'link' => 'https://wallpaperscraft.com/catalog/food',
        'path' => 'food'
    ],
    [
        'id' => 14,
        'name' => 'Holidays',
        'link' => 'https://wallpaperscraft.com/catalog/holidays',
        'path' => 'holidays'
    ],
    [
        'id' => 15,
        'name' => 'Love',
        'link' => 'https://wallpaperscraft.com/catalog/love',
        'path' => 'love'
    ],
    [
        'id' => 16,
        'name' => 'Macro',
        'link' => 'https://wallpaperscraft.com/catalog/macro',
        'path' => 'macro'
    ],
    [
        'id' => 17,
        'name' => 'Minimalism',
        'link' => 'https://wallpaperscraft.com/catalog/minimalism',
        'path' => 'minimalism'
    ],
    [
        'id' => 18,
        'name' => 'Motorcycles',
        'link' => 'https://wallpaperscraft.com/catalog/motorcycles',
        'path' => 'motorcycles'
    ],
    [
        'id' => 19,
        'name' => 'Music',
        'link' => 'https://wallpaperscraft.com/catalog/music',
        'path' => 'music'
    ],
    [
        'id' => 20,
        'name' => 'Nature',
        'link' => 'https://wallpaperscraft.com/catalog/nature',
        'path' => 'nature'
    ],
    [
        'id' => 21,
        'name' => 'Space',
        'link' => 'https://wallpaperscraft.com/catalog/space',
        'path' => 'space'
    ],
    [
        'id' => 22,
        'name' => 'Sport',
        'link' => 'https://wallpaperscraft.com/catalog/sport',
        'path' => 'sport'
    ],
    [
        'id' => 23,
        'name' => 'Technologies',
        'link' => 'https://wallpaperscraft.com/catalog/hi-tech',
        'path' => 'hi-tech'
    ],
    [
        'id' => 24,
        'name' => 'Textures',
        'link' => 'https://wallpaperscraft.com/catalog/textures',
        'path' => 'textures'
    ],
    [
        'id' => 25,
        'name' => 'Vector',
        'link' => 'https://wallpaperscraft.com/catalog/vector',
        'path' => 'vector'
    ],
    [
        'id' => 26,
        'name' => 'Words',
        'link' => 'https://wallpaperscraft.com/catalog/words',
        'path' => 'words'
    ],
    [
        'id' => 27,
        'name' => 'Other',
        'link' => 'https://wallpaperscraft.com/catalog/other',
        'path' => 'other'
    ]
];

const CLASS_IMAGE = 'wallpapers__image';

function getHtmlString(string $url)
{
    $httpClient = new \GuzzleHttp\Client();
    $response = $httpClient->get($url);
    $htmlString = (string) $response->getBody();
    return $htmlString;
}

function findElem(string $htmlString)
{
    // type = 1 => class
    // type = 2 => id
    // type = 3 => attribute
    $output = [];
    $urlKeys = [];

    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($htmlString);
    $xpath = new DOMXPath($doc);
//    $titles = $xpath->query('//li[@class="wallpapers__item"]//a[@class="wallpapers__link"]//span[@class="wallpapers__canvas"]//img[@class="wallpapers__image"]');
    $elems = $xpath->evaluate('//li[@class="wallpapers__item"]//a[@class="wallpapers__link"]');
    /** @var DOMElement $elem */
    foreach ($elems as $elem) {
        $origLink = 'https://wallpaperscraft.com' . $elem->getAttribute('href');
        if (!in_array($origLink, $urlKeys)) {
            $urlKeys[] = $elem->getAttribute('href');
        }
        $titles = $elem->getElementsByTagName('img');
        foreach ($titles as $title) {
            $arr = [];
            $imageUrlKey = $title->getAttribute('src');
            $arr['link'] = $imageUrlKey;
            $alt = $title->getAttribute('alt');
            $alt = substr($alt, strlen("Preview wallpaper_"));
            $altArr = explode(",", $alt);
            $altArr = array_slice($altArr, 0, 2);
            $altArr = array_map(function ($e) {
                return ucwords($e);
            }, $altArr);
            $alt = implode(",", $altArr);
            $arr['alt'] = $alt;
            $arr['orig'] = $origLink;
            $output[] = $arr;
            break;
        }
        break;
    }

    $details = [];

    foreach ($urlKeys as $urlKey) {
        $urlKeyFull = 'https://wallpaperscraft.com' . $urlKey;
        $imageDetailHtml = getHtmlString($urlKeyFull);
        $details[$urlKey] = [];
        $details[$urlKey]['base'] = $urlKey;

        $docDetail = new DOMDocument();
        $docDetail->loadHTML($imageDetailHtml);
        $xpathDetail = new DOMXPath($docDetail);
        $elemsDetail = $xpathDetail->evaluate('//div[@class="content-main"]//h1');

        /** @var DOMElement $elemDetail */
        foreach ($elemsDetail as $elemDetail) {
            $headingTxt = $elemDetail->textContent;
            $details[$urlKey]['heading'] = $headingTxt;
        }
        $elemsDetail = $xpathDetail->evaluate('//div[@class="content-main"]//div[@class="wallpaper "]//div[@class="wallpaper__placeholder"]//img[@class="wallpaper__image"]');
        /** @var DOMElement $elemDetail */
        foreach ($elemsDetail as $elemDetail) {
            $details[$urlKey]['baseImage'] = $elemDetail->getAttribute('src');
            $details[$urlKey]['alt'] = $elemDetail->getAttribute('alt');
        }
        $elemsDetail = $xpathDetail->evaluate('//div[@class="content-main"]//div[@class="wallpaper "]//div[@class="author__block"]//div[@class="author__row"]');
        /** @var DOMElement $elemDetail */
        foreach ($elemsDetail as $idx => $elemDetail) {
            if (!$idx) {
                $details[$urlKey]['author'] = $elemDetail->textContent;
            }
            if ($idx) {
                $details[$urlKey]['license'] = $elemDetail->textContent;
            }
        }
        $elemsDetail = $xpathDetail->evaluate('//div[@class="content-main"]//div[@class="wallpaper "]//a[@class="author__link"]');
        /** @var DOMElement $elemDetail */
        foreach ($elemsDetail as $elemDetail) {
            $details[$urlKey]['source'] = $elemDetail->getAttribute('href');
        }
    }
    return ['output' => $output, 'details' => $details];
}

function crawlHome()
{
    $baseUrl = BASE_URL;
    $htmlString = getHtmlString($baseUrl);
    $output = findElem($htmlString);

    return json_encode($output['output']);
}

function crawlCates()
{
    $cateList = CATEGORIES;
    $cateListData = [];
    foreach($cateList as $cate) {
        $cateData = [];
        $cateData[$cate['path']] = [];
        $cateData[$cate['path']]['id'] = $cate['id'];
        $cateData[$cate['path']]['name'] = $cate['name'];
        $cateData[$cate['path']]['origLink'] = $cate['link'];
        $cateData[$cate['path']]['path'] = $cate['path'];
        $cateData[$cate['path']]['pages'] = [];
        for ($i = 1; $i <= 10; $i++) {
            $pageNumPar = 'page%p3%';
            $pageNum = str_replace('%p3%', $i, $pageNumPar);
            $newCateLink = $cate['link'] . '/' . $pageNum;
            $catePageHtmlString = getHtmlString($newCateLink);
            $catePageOuputHtml = findElem($catePageHtmlString);
            $cateData[$cate['path']]['pages'][] = $catePageOuputHtml['output'];
            echo "Crawl done link: " . $newCateLink . "\n";
        }
        $cateListData[] = $cateData;
    }
    return json_encode($cateListData);
}

function crawlListCate()
{
    $listCate = CATEGORIES;
    return json_encode($listCate);
}

function writeFile($fileName, $text = null)
{
    $myfile = fopen($fileName, "w") or die("Unable to open file!");
    fwrite($myfile, $text);
    fclose($myfile);
}

$homeOutput = crawlHome();
$listCate = crawlListCate();
$cates = crawlCates();
writeFile("list_categories.json", $listCate);
writeFile("home.json", $homeOutput);
writeFile("categories.json", $cates);