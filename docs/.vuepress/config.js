const glob = require('glob');
const fs = require('fs');
const { description } = require('../package')

// Convert text to have uppercase first characters.
const slugToTitle = (text) => {
  const parts = text.split('-');
  parts.shift();

  return parts
    .join(' ')
    .replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())))
    .replace('.md', '')
    .replace('# ', '');
};

const getTitleForFile = (file) => {
  const lines = fs.readFileSync(file, 'utf-8').split('\n');
  return lines[0].replace('# ', '') || undefined;
};

const sidebar = glob
  .sync('./!(vendor|node_modules)')
  .map((folder) => {
    const files = glob.sync(`${folder}/*.md`);
    if (! files.length) {
      return false;
    }

    return {
      title: slugToTitle(folder),
      path: files[0].replace('.md', '').replace('./', '/'),
      collapsable: false,
      sidebarDepth: 3,
      children: files.map((file) => ({
        title: getTitleForFile(file) || slugToTitle(file.split('/').pop()),
        path: file.replace('.md', '').replace('./', '/'),
      })),
    };
  })
  .filter(item => false !== item);

module.exports = {
  title: 'Mantle',
  description,
  base: '/',
  head: [
    // ['meta', { name: 'theme-color', content: '#3eaf7c' }],
    ['meta', { name: 'apple-mobile-web-app-capable', content: 'yes' }],
    ['meta', { name: 'apple-mobile-web-app-status-bar-style', content: 'black' }],
  ],
  themeConfig: {
    activeHeaderLinks: false,
    displayAllHeaders: false,
    docsBranch: 'main',
    docsDir: 'docs',
    editLinks: false,
    editLinks: true,
    editLinkText: 'Help us improve this page!',
    lastUpdated: false,
    repo: 'alleyinteractive/mantle-site',
    nav: [
      { text: 'Home', link: '/', target: '_self', },
      { text: 'Alley', link: 'https://alley.co/', },
    ],
    sidebar,
  },
  markdown: {
    toc: {
      includeLevel: [1,2,3,4],
    },
  },
  plugins: [
    '@vuepress/plugin-back-to-top',
    '@vuepress/plugin-medium-zoom',
    [
      'vuepress-plugin-clean-urls',
      {
        normalSuffix: '/',
        indexSuffix: '/',
        notFoundPath: '/404.html',
      },
    ],
  ]
}
