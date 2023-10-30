const express = require("express");
const path = require("path");
const axios = require("axios");
var cookieParser = require('cookie-parser');
var bodyParser = require('body-parser');
const fs = require('fs');

const app = express();

// Set view engine EJS
app.set('views', path.join(__dirname, '/app/views'));
app.set("view engine", "ejs");

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname + '/app/public')));

const categories = [
  {
      'id': 1,
      'name': '3D',
      'link': 'https://nwallpaper.deta.dev/catalog/3d'
  },
  {
      'id': 2,
      'name': 'Abstract',
      'link': 'https://nwallpaper.deta.dev/catalog/abstract'
  },
  {
      'id': 3,
      'name': 'Animals',
      'link': 'https://nwallpaper.deta.dev/catalog/animals'
  },
  {
      'id': 4,
      'name': 'Anime',
      'link': 'https://nwallpaper.deta.dev/catalog/anime'
  },
  {
      'id': 5,
      'name': 'Art',
      'link': 'https://nwallpaper.deta.dev/catalog/art'
  },
  {
      'id': 6,
      'name': 'Black',
      'link': 'https://nwallpaper.deta.dev/catalog/black'
  },
  {
      'id': 7,
      'name': 'Black and white',
      'link': 'https://nwallpaper.deta.dev/catalog/black_and_white'
  },
  {
      'id': 8,
      'name': 'Cars',
      'link': 'https://nwallpaper.deta.dev/catalog/cars'
  },
  {
      'id': 9,
      'name': 'City',
      'link': 'https://nwallpaper.deta.dev/catalog/city'
  },
  {
      'id': 10,
      'name': 'Dark',
      'link': 'https://nwallpaper.deta.dev/catalog/dark'
  },
  {
      'id': 11,
      'name': 'Fantasy',
      'link': 'https://nwallpaper.deta.dev/catalog/fantasy'
  },
  {
      'id': 12,
      'name': 'Flowers',
      'link': 'https://nwallpaper.deta.dev/catalog/flowers'
  },
  {
      'id': 13,
      'name': 'Food',
      'link': 'https://nwallpaper.deta.dev/catalog/food'
  },
  {
      'id': 14,
      'name': 'Holidays',
      'link': 'https://nwallpaper.deta.dev/catalog/holidays'
  },
  {
      'id': 15,
      'name': 'Love',
      'link': 'https://nwallpaper.deta.dev/catalog/love'
  },
  {
      'id': 16,
      'name': 'Macro',
      'link': 'https://nwallpaper.deta.dev/catalog/macro'
  },
  {
      'id': 17,
      'name': 'Minimalism',
      'link': 'https://nwallpaper.deta.dev/catalog/minimalism'
  },
  {
      'id': 18,
      'name': 'Motorcycles',
      'link': 'https://nwallpaper.deta.dev/catalog/motorcycles'
  },
  {
      'id': 19,
      'name': 'Music',
      'link': 'https://nwallpaper.deta.dev/catalog/music'
  },
  {
      'id': 20,
      'name': 'Nature',
      'link': 'https://nwallpaper.deta.dev/catalog/nature'
  },
  {
      'id': 21,
      'name': 'Space',
      'link': 'https://nwallpaper.deta.dev/catalog/space'
  },
  {
      'id': 22,
      'name': 'Sport',
      'link': 'https://nwallpaper.deta.dev/catalog/sport'
  },
  {
      'id': 23,
      'name': 'Technologies',
      'link': 'https://nwallpaper.deta.dev/catalog/hi-tech'
  },
  {
      'id': 24,
      'name': 'Textures',
      'link': 'https://nwallpaper.deta.dev/catalog/textures'
  },
  {
      'id': 25,
      'name': 'Vector',
      'link': 'https://nwallpaper.deta.dev/catalog/vector'
  },
  {
      'id': 26,
      'name': 'Words',
      'link': 'https://nwallpaper.deta.dev/catalog/words'
  },
  {
      'id': 27,
      'name': 'Other',
      'link': 'https://nwallpaper.deta.dev/catalog/other'
  }
];

const seotitleDefault = "Desktop wallpapers, hd backgrounds, free hd wallpapers download, wallpaperscraft";
const seoContentDefault = "Desktop wallpapers, hd backgrounds, free hd wallpapers download, wallpaperscraft";
const seoCanonicalHome = "https://nwallpaper.deta.dev/";
const seoCanonicalCate = "https://nwallpaper.deta.dev/catalog/";
const seoKeywordsDefault = "Desktop wallpapers, hd backgrounds, free hd wallpapers download";

// Rounter
// 1. Index page
app.get("/", async (req, res) => {
  fs.readFile(path.join(__dirname, "/data/home.json"), "utf-8", (err, data) => {
    if (err) {
      res.render(path.join(__dirname, "/app/views/index"), {
            isLoaded: false,
            categories: categories,
            seoContent: seoContentDefault,
            seoCanonical: seoCanonicalHome,
            seoTitle: seotitleDefault,
            seoKeywords: seoKeywordsDefault
        });
    }
    res.render(path.join(__dirname, "/app/views/index"), {
        isLoaded: true,
        images: JSON.parse(data),
        categories: categories,
        seoContent: seoContentDefault,
        seoCanonical: seoCanonicalHome,
        seoTitle: seotitleDefault,
        seoKeywords: seoKeywordsDefault
    });
  });
});

// 2. Catalog page
app.get('/catalog/:topicId/page/:pageId', (req, res) => {
    fs.readFile(path.join(__dirname, "/data/categories.json"), "utf-8", (err, data) => {
            if (err) {
            res.render(path.join(__dirname, "/app/views/catalog"), {
                loaded: false,
                categories: categories,
                seoContent: seoContentDefault,
                seoCanonical: seoCanonicalCate,
                seoTitle: seotitleDefault,
                seoKeywords: seoKeywordsDefault
            });
        }
        var topic = req.params.topicId ? req.params.topicId : '3d';
        var pageId = req.params.pageId ? req.params.pageId : 1;
        if (!topic) {
            res.render(path.join(__dirname, "/app/views/catalog"), {
                loaded: false,
                categories: categories,
                seoContent: seoContentDefault,
                seoCanonical: seoCanonicalCate,
                seoTitle: seotitleDefault,
                seoKeywords: seoKeywordsDefault
            });
        }
        if (pageId < 1) {
            pageId = 1;
        }
        if (pageId > 10) {
            pageId = 10;
        }
        data = JSON.parse(data);
        var nextLink = null,
            currentLink = null,
            prevLink = null,
            nextPageId = null,
            prevPageId = null,
            activeItem = 0,
            currentPage = pageId;
        if (currentPage <= 1) {
            activeItem = 1;
            prevPageId = 1;
            prevLink = '#';
            currentPage = 2;
            currentLink = 'https://nwallpaper.deta.dev/catalog/' + topic + '/page/' + currentPage;
            nextPageId = 3;
            nextLink = 'https://nwallpaper.deta.dev/catalog/' + topic + '/page/' + nextPageId;
        } else if (currentPage > 1 && currentPage < 10) {
            activeItem = 2;
            prevPageId = parseInt(currentPage) - 1;
            prevLink = 'https://nwallpaper.deta.dev/catalog/' + topic + '/page/' + prevPageId;
            currentLink = '#';
            nextPageId = parseInt(currentPage) + 1;
            nextLink = 'https://nwallpaper.deta.dev/catalog/' + topic + '/page/' + nextPageId
        } else if (currentPage >= 10) {
            activeItem = 3;
            prevPageId = 8;
            prevLink = 'https://nwallpaper.deta.dev/catalog/' + topic + '/page/' + prevPageId;
            currentPage = 9;
            currentLink = 'https://nwallpaper.deta.dev/catalog/' + topic + '/page/' + currentPage;
            nextPageId = 10;
            nextLink = 'https://nwallpaper.deta.dev/catalog/' + topic + '/page/' + nextPageId;
        }
        data.forEach(function (cateData, idx) {
            if (cateData[topic] && cateData[topic] !== undefined) {
                var categoryData = cateData[topic],
                    idx = parseInt(pageId) - 1,
                    pagesData = categoryData['pages'][idx];
                if (pagesData && pagesData !== undefined) {
                    res.render(path.join(__dirname, "/app/views/catalog"), {
                        isLoaded: true,
                        categories: categories,
                        images: pagesData,
                        topic: categoryData['name'],
                        orig: categoryData['origLink'],
                        nextLink: nextLink,
                        prevLink: prevLink,
                        nextPageId: nextPageId,
                        prevPageId: prevPageId,
                        currentPageId: currentPage,
                        activeItem: activeItem,
                        currentLink: currentLink,
                        seoContent: categoryData['name'] + ' wallpapers and backgrounds, free '+categoryData['name']+' hd wallpapers download',
                        seoCanonical: seoCanonicalCate,
                        seoTitle: categoryData['name'] + ' wallpapers and backgrounds, free '+categoryData['name']+' hd wallpapers download, wallpaperscraft',
                        seoKeywords: categoryData['name'] + ' wallpapers, free ' + categoryData['name'] + ' hd wallpapers download'
                    });
                }
            }
        });

        res.render(path.join(__dirname, "/app/views/catalog"), {
            isLoaded: false,
            categories: categories,
            seoContent: seoContentDefault,
            seoCanonical: seoCanonicalCate,
            seoTitle: seotitleDefault,
            seoKeywords: seoKeywordsDefault
        });
    });
});

// 3. Default catalog
app.get('/catalog', (req, res) => {
    res.redirect('/catalog/3d/page/1');
});

// 3. Default each topic
app.get('/catalog/:topicId', (req, res) => {
    var topic = req.params.topicId ? req.params.topicId : '3d';
    res.redirect('/catalog/' + topic + '/page/1');
});

// 4. Link for each images detail
app.get('/wallpaper/:imageUrl', (req, res) => {
    var imageUrl = req.params.imageUrl;
    if (!imageUrl) {
        res.redirect('/');
    }
    var topic = req.params.topicId ? req.params.topicId : '3d';
    res.redirect('/catalog/' + topic + '/page/1');
});


// Port 8080
app.listen(8080);

module.exports = app;
