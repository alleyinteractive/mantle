const { description } = require('../package');

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
    repo: 'alleyinteractive/mantle',
    nav: [
      { text: 'Home', link: '/', target: '_self', },
      { text: 'Alley', link: 'https://alley.co/', },
    ],
    sidebar: require('./sidebar'),
    algolia: {
      apiKey: 'f4cbda59264a3b8e945405e83fc6d685',
      indexName: 'mantle'
    },
  },
  markdown: {
    toc: {
      includeLevel: [1,2,3,4],
    },
  },
  plugins: [
    '@vuepress/plugin-back-to-top',
    '@vuepress/plugin-medium-zoom',
    'check-md',
    [
      'vuepress-plugin-clean-urls',
      {
        normalSuffix: '/',
        indexSuffix: '/',
        notFoundPath: '/404.html',
      },
    ],
    [
      '@vuepress/google-analytics',
      {
        'ga': 'G-G4HGJSHN3S',
      }
    ]
  ]
}
