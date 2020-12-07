function prefix(prefix, children) {
  return children.map(child => `${prefix}/${child}`)
}

module.exports = [
  {
    title: 'Getting Started',
    collapsable: false,
    children: prefix('getting-started', [
      'installation',
      'directory-structure',
      'tutorial',
    ]),
  },
  {
    title: 'Architecture',
    collapsable: false,
    children: prefix('architecture', [
      'architecture',
      'configuration',
    ]),
  },
  {
    title: 'Basics',
    collapsable: false,
    children: prefix('basics', [
      'requests',
      'templating',
      'helpers',
      'commands',
    ]),
  },
  {
    title: 'Models',
    collapsable: false,
    children: prefix('models', [
      'models',
      'querying-models',
      'model-relationships',
      'model-registration',
      'model-factory',
      'serialization',
      'seeding',
    ]),
  },
  {
    title: 'Features',
    collapsable: false,
    children: prefix('features', [
      'queue',
      'scheduling-tasks',
      'hooks',
      'file-system',
      'caper',
      'cache',
    ]),
  },
  {
    title: 'Testing',
    collapsable: false,
    children: prefix('testing', [
      'test-framework',
      'transition',
      'requests',
      'remote-requests',
      'hooks',
    ]),
  },
]
