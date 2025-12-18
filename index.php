<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>100 Search Engine Launcher (By Category)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen;
    background:#f8fafc;
    color:#0f172a;
    padding:20px;
  }
  .container {
    max-width:1100px;
    margin:auto;
    background:#ffffff;
    padding:24px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(15,23,42,0.08);
  }
  h1 {
    font-size:28px;
    margin-bottom:6px;
  }
  h2 {
    font-size:18px;
    margin-bottom:10px;
  }
  p { color:#475569; }
  input[type=text] {
    width:100%;
    padding:12px 14px;
    border-radius:12px;
    border:1px solid #e2e8f0;
    margin-bottom:16px;
    font-size:15px;
  }
  input[type=text]:focus {
    outline:none;
    border-color:#94a3b8;
  }
  button {
    padding:8px 14px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    background:#0f172a;
    color:white;
    font-size:14px;
  }
  button:hover { background:#020617; }
  .category {
    border:1px solid #e2e8f0;
    border-radius:14px;
    padding:14px;
    margin-bottom:16px;
    background:#f9fafb;
  }
  .engines {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:8px;
  }
  label {
    font-size:14px;
    padding:6px 8px;
    border-radius:8px;
    background:#ffffff;
    border:1px solid #e5e7eb;
    display:flex;
    align-items:center;
    gap:6px;
  }
  label:hover { background:#f1f5f9; }
  .note {
    font-size:13px;
    color:#64748b;
    margin-top:12px;
  }
</style>
</head>
<body>
<div class="container">
  <h1>🔍 100 Search Engine Launcher</h1>
  <p>Satu keyword → pilih search engine by kategori atau manual → buka banyak tab.</p>

  <div style="display:flex; gap:12px; align-items:stretch; margin-bottom:16px;">
    <input type="text" id="keyword" placeholder="Masukkan kata kunci..." style="flex:1; margin-bottom:0;" />
    <button onclick="runSearch()" style="padding:0 24px; font-size:16px; border-radius:14px;">🔍 Open<br>Search</button>
  </div>

  <div id="categories"></div>

  

  <div class="note">⚠️ Disarankan tidak mencentang lebih dari 20 engine sekaligus (popup blocker).</div>
</div>

<script>
const data = {
  "Global Popular": [
    ['Google','https://www.google.com/search?q={query}'],
    ['Bing','https://www.bing.com/search?q={query}'],
    ['DuckDuckGo','https://duckduckgo.com/?q={query}'],
    ['Yahoo','https://search.yahoo.com/search?p={query}'],
    ['Yandex','https://yandex.com/search/?text={query}'],
    ['Baidu','https://www.baidu.com/s?wd={query}'],
    ['Brave Search','https://search.brave.com/search?q={query}'],
    ['Startpage','https://www.startpage.com/do/search?q={query}'],
    ['Qwant','https://www.qwant.com/?q={query}'],
    ['Ecosia','https://www.ecosia.org/search?q={query}']
  ],

  "Privacy Focused": [
    ['Swisscows','https://swisscows.com/web?query={query}'],
    ['Mojeek','https://www.mojeek.com/search?q={query}'],
    ['MetaGer','https://metager.org/meta/meta.ger3?eingabe={query}'],
    ['Gibiru','https://gibiru.com/results.html?q={query}'],
    ['SearX','https://searx.be/search?q={query}'],
    ['SearXNG','https://search.bus-hit.me/search?q={query}'],
    ['Disconnect Search','https://search.disconnect.me/searchTerms/search?query={query}'],
    ['Whoogle','https://whoogle.sdf.org/search?q={query}'],
    ['Yippy','https://yippy.com/search?query={query}'],
    ['Peekier','https://peekier.com/#!{query}']
  ],

  "Regional": [
    ['Naver','https://search.naver.com/search.naver?query={query}'],
    ['Daum','https://search.daum.net/search?q={query}'],
    ['Seznam','https://search.seznam.cz/?q={query}'],
    ['Rambler','https://nova.rambler.ru/search?query={query}'],
    ['Sogou','https://www.sogou.com/web?query={query}'],
    ['360 Search','https://www.so.com/s?q={query}'],
    ['Najdi.si','https://najdi.si/najdi/{query}'],
    ['Onet','https://szukaj.onet.pl/wyniki.html?qt={query}'],
    ['Goo','https://search.goo.ne.jp/web.jsp?MT={query}'],
    ['Yandex Images','https://yandex.com/images/search?text={query}']
  ],

  "Alternative / Niche": [
    ['Dogpile','https://www.dogpile.com/serp?q={query}'],
    ['WebCrawler','https://www.webcrawler.com/serp?q={query}'],
    ['Info.com','https://www.info.com/serp?q={query}'],
    ['Lycos','https://search.lycos.com/web?q={query}'],
    ['Search Encrypt','https://www.searchencrypt.com/search?eq={query}'],
    ['Boardreader','https://boardreader.com/s/{query}.html'],
    ['Million Short','https://millionshort.com/search?keywords={query}'],
    ['Gigablast','https://www.gigablast.com/search?q={query}'],
    ['ExactSeek','https://www.exactseek.com/search.php?q={query}'],
    ['Wiby','https://wiby.me/?q={query}']
  ],

  "Academic / Research": [
    ['Google Scholar','https://scholar.google.com/scholar?q={query}'],
    ['Semantic Scholar','https://www.semanticscholar.org/search?q={query}'],
    ['BASE','https://www.base-search.net/Search/Results?lookfor={query}'],
    ['CORE','https://core.ac.uk/search?q={query}'],
    ['Science.gov','https://www.science.gov/search/?query={query}'],
    ['RefSeek','https://www.refseek.com/search?q={query}'],
    ['WorldWideScience','https://worldwidescience.org/search?q={query}'],
    ['ERIC','https://eric.ed.gov/?q={query}'],
    ['Microsoft Academic (Archive)','https://www.microsoft.com/en-us/research/search/?q={query}'],
    ['JSTOR','https://www.jstor.org/action/doBasicSearch?Query={query}']
  ]
};

function render() {
  const wrap = document.getElementById('categories');
  Object.entries(data).forEach(([cat, engines]) => {
    const div = document.createElement('div');
    div.className = 'category';
    div.innerHTML = `
      <h2>${cat}</h2>
      <button onclick="toggleCategory(this)">Select All</button>
      <div class="engines">
        ${engines.map(e => `
          <label><input type="checkbox" data-url="${e[1]}"> ${e[0]}</label>
        `).join('')}
      </div>
    `;
    wrap.appendChild(div);
  });
}

function toggleCategory(btn) {
  const boxes = btn.parentElement.querySelectorAll('input[type=checkbox]');
  const check = [...boxes].some(b => !b.checked);
  boxes.forEach(b => b.checked = check);
}

function runSearch() {
  const q = document.getElementById('keyword').value.trim();
  if (!q) return alert('Masukkan kata kunci');
  document.querySelectorAll('input[type=checkbox]:checked').forEach(b => {
    window.open(b.dataset.url.replace('{query}', encodeURIComponent(q)), '_blank');
  });
}

render();
</script>
</body>
</html>
