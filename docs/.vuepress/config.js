const { description } = require('../package');

module.exports = {
  title: 'Mantle',
  description,
  base: '/',
  head: [
    ['meta', { name: 'google-site-verification', content: '9j6GWEdJJsL1zqzPRBMYahbaFg0NNj-NVglppOfGyJE' }],
    ['meta', { name: 'apple-mobile-web-app-capable', content: 'yes' }],
    ['meta', { name: 'apple-mobile-web-app-status-bar-style', content: 'black' }],
    ['meta', { property: 'og:image', content: 'https://repository-images.githubusercontent.com/261240189/e61bc280-2d73-11eb-92d0-249447854ca0' }],
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
    ],
    [
      'sitemap',
      {
        hostname: 'https://mantle.alley.co',
        exclude: ['/404.html'],
      }
    ],
  ]
}
