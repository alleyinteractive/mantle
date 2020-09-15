const glob = require('glob');
const { description } = require('../package')

// Convert text to have uppercase first characters.
const slugToTitle = (text) => {
  const parts = text.split('-');
  parts.shift();

  return parts
    .join(' ')
    .replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())))
    .replace('.md', '');
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
      sidebarDepth: 1,
      children: files.map((file) => ({
        title: slugToTitle(file.split('/').pop()),
        path: file.replace('.md', '').replace('./', '/'),
      })),
    };
  })
  .filter(item => false !== item);

module.exports = {
  /**
   * Ref：https://v1.vuepress.vuejs.org/config/#title
   */
  title: 'Mantle',
  /**
   * Ref：https://v1.vuepress.vuejs.org/config/#description
   */
  description,
  head: [
    ['meta', { name: 'theme-color', content: '#3eaf7c' }],
    ['meta', { name: 'apple-mobile-web-app-capable', content: 'yes' }],
    ['meta', { name: 'apple-mobile-web-app-status-bar-style', content: 'black' }]
    ['meta', { name: 'robots', content: 'noindex' }]
  ],
  themeConfig: {
    docsBranch: 'main',
    docsDir: 'docs',
    editLinks: false,
    editLinks: true,
    editLinkText: 'Help us improve this page!',
    lastUpdated: 'Last Updated',
    repo: 'alleyinteractive/mantle-site',
    nav: [
      { text: 'Home', link: '/', target: '_self', },
      { text: 'Alley', link: 'https://alley.co/', },
    ],
    sidebar,
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
