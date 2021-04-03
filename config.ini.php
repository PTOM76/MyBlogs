<?php
/*--------------------------------
 @name MyBlogs
 @author K
 @copyright 2020-2021 K
 @license GPLv3
--------------------------------*/

// ブログのタイトル
define("TITLE", "My Blog");

// ブログの説明(タイトル下の文字)
define("SUMMARY", "<strong>MyBlogs</strong>");

// ブログの管理者
define("ADMIN", "HogeHoge");

// ブログの管理者認証パスワード(必ず変えましょう)
define("ADMIN_PASS", "Hoge1234");

// ブログのスキン
define("SKIN", "default");

// ブログの言語 langの(〇〇_〇〇).phpの〇〇_〇〇の部分
define("LANG", "ja_jp");

// フォルダ関連
define("SKIN_PATH", "skin/");
define("ARTICLE_PATH", "data/");
define("IMAGE_PATH", "image/");
define("LANG_PATH", "lang/");
define("PLUG_PATH", "plugins/");
define("LIBS_PATH", "libs/");
define("CACHE_PATH", "cache/");

define('cache_page_dates_file', "pagedates.txt");

// アイコン(base64)
// 時計
define('BASE64_TIME_ICON', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAACXBIWXMAADXUAAA11AFeZeUIAAAEpElEQVRIiZ2WUUwTdxzHv1z//V+v16XGBLVlZUkL1INFs5QJoris9UXmA9kwPtgIMybLHgckyoMvexCHPJi4PWoQ2UsjxCzMoPKwpGldjNmCps1qV0kYo8JGFG5wXP//u+5hnOmYQN336fL/fn/fT/53/8tdBbZQa2trq9fr/YgxdoxS6ne5XC7LW1tb0xljM5TSCVVVJ2/fvv3dZj0Vr1uMRCIhj8fzjcPhaLLWVlZWlmRZdhf+0UO73V4viuJOy+ec51RVPT06OprcFnLy5MkvKaXnRFGknHO9vr5+7sCBA382NDS839vby2dnZ3OTk5NBAHjw4MFEIpHwpdPpOpvNZuecG6ZpXhseHv5sU8iJEyeuud3uMwDg9/uXotHois/n8wJAJpPB4OAg8vn8zPj4eHXp3Pz8fKanpycnSVIbAOi6Pnbz5s1PLF8o3YHb7T5TKBT43r17s319fW4LUCpJkujGtd27dwdHRkbagsHgAgCIovhxNBod+BckHA43UkrPAcD+/fvTPT09tRuLgsEgOOeGJEniRs9Sb2/vLgtECOnu6Og4+Ari9Xq/FkWRBgKB5e7u7n2blei6zgghzs18C6Rp2h1CiE2W5asAIBw5cuSww+FoMgyDnTp16q+tChhjnDGmb5UBgIsXL75nGAaz2+2hSCTSLHg8nuMAoCjK7697BqUyDGNJ1/XV7SDV1dUeRVGeA4DX620XGGPHAODQoUPT2w0zxjRd17fcraVQKLQAAJqmHRUopf4XL148bWlp+XC7QdM0DQAz5UDC4XBI13WVUhoUXC6Xy2azzZYzeLyubtdXhtGkqupCOXnG2FOn0+kSAECSJFLOUNOVKxPv3LsnfzswMDM3N/dbGSNZYP0Im6ZZVQ7kXV33TcViuceLi40XLlzYmc1mta3yxWKxDgCEtbU1XRCEPeVAKKWHm9vbA36//2dBEOT+/n5kMplNjzSltFZV1SWboiinJUnaU1lZOeHz+WrKgbW0tHhkWX785MmTykQiIUxPT2eam5srSzPxePx+KpVSTNOcFSilEwCQTCbfLgdgKRKJ7Ovr6zMLhcKvqVSqvr+/f4kxFrf8ZDLpWb+8JaiqOgkAqVQqOD8/n3kTUG1trTQ0NPRHIBB4+ezZM/fZs2erHz16dDefz2fT6XQNAKiqercCALq6urKEkBpN0+6MjIy0vQnI0qVLl17mcrkdjDFmGMZzh8Ph45xnh4aG6gQAWF5e7uKcc0mS2gYHB8t6Bzbq/PnzOxRF+UkQhIp1AF9dXT0NrB/hsbGxhGma1wEgk8nsunz58v8CGYbhsNlsBACKxeK1WCz2IwDYrMDU1NR4Q0PDPkKIsri4KMdisTuNjY0ut9v91nbl+Xw+29nZ+YOmaR8AQKFQuDU8PNxp+f/5xkej0QFCyBeEEGIYBlMU5XkoFFoIh8Ohjdl4PH4/mUx60ul0DaXUwRgrALh+48aNz0tzr/1b6ejoOCjL8lW73f6qWNd1lTH2FEC2WCzWUUprRVF8tUvG2C+apn1q3aJtIZbC4XBzVVVVu6ZpRymlQafTWfrftco5nyGETGiaNjk6Ovr9Zj1/A6cRAiVv2FfVAAAAAElFTkSuQmCC');

?>