class SimpleImage {
  static get toolbox() {
    return {
      title: 'Image',
      icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>'
    };
  }

  static get sanitize(){
    return {
      url: false, // disallow HTML
      caption: {} // only tags from Inline Toolbar
    }
  }

  static get tunes() {
    return [
      {
        name: 'withBorder',
        icon: `<svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-square-plus-2"><path d="M12.5 21h-7.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>`,
        title: 'With border',
        toggle: true,
      },
      {
        name: 'stretched',
        icon: `<svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-maximize"><path d="M16 4l4 0l0 4" /><path d="M14 10l6 -6" /><path d="M8 20l-4 0l0 -4" /><path d="M4 20l6 -6" /><path d="M16 20l4 0l0 -4" /><path d="M14 14l6 6" /><path d="M8 4l-4 0l0 4" /><path d="M4 4l6 6" /></svg>`,
        title: 'Stretch image',
        toggle: true,
      },
      {
        name: 'withBackground',
        icon: `<svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-texture"><path d="M6 3l-3 3" /><path d="M21 18l-3 3" /><path d="M11 3l-8 8" /><path d="M16 3l-13 13" /><path d="M21 3l-18 18" /><path d="M21 8l-13 13" /><path d="M21 13l-8 8" /></svg>`,
        title: 'With background',
        toggle: true,
      },
    ];
  }

  constructor({data, api, config, block}) {
    this.api = api;
    this.config = config || {};
    this.data = {
      url: data.url || '',
      caption: data.caption || '',
      withBorder: data.withBorder !== undefined ? data.withBorder : false,
      withBackground: data.withBackground !== undefined ? data.withBackground : false,
      stretched: data.stretched !== undefined ? data.stretched : false,
    };

    this.block = block;

    this.wrapper = undefined;
  }

  render() {
    this.wrapper = document.createElement('div');
    this.wrapper.classList.add('simple-image');

    if (this.data && this.data.url) {
      this._createImage(this.data.url, this.data.caption);
      return this.wrapper;
    }

    const input = document.createElement('input');
    input.placeholder = this.api.i18n.t(this.config.placeholder || 'Paste an image URL...');
    input.addEventListener('paste', (event) => {
      this._createImage(event.clipboardData.getData('text'));
    });

    this.wrapper.appendChild(input);

    return this.wrapper;
  }

  _createImage(url, captionText) {
    const image = document.createElement('img');
    const caption = document.createElement('div');

    image.src = url;
    caption.contentEditable = 'true';
    caption.setAttribute('placeholder', 'Image caption');
    caption.innerHTML = captionText || '';

    this.wrapper.innerHTML = '';
    this.wrapper.appendChild(image);
    this.wrapper.appendChild(caption);

    this._applyTunes();
  }

  save(blockContent) {
    const image = blockContent.querySelector('img');
    const caption = blockContent.querySelector('[contenteditable]');

    return Object.assign(this.data, {
      url: image.src,
      caption: caption.innerHTML || ''
    });
  }

  validate(savedData) {
    if (!savedData.url.trim()) {
      return false;
    }

    return true;
  }

  renderSettings() {
    return SimpleImage.tunes.map(tune=> ({
      icon: tune.icon,
      label: this.api.i18n.t(tune.title),
      name: tune.name,
      toggle: tune.toggle,
      isActive: !!this.data[tune.name],
      onActivate: () => {
        this._toggleTune(tune.name);
        this._applyTunes();
      },
    }));
  }

  _toggleTune(tune) {
    this.data[tune] = !this.data[tune];
    this._applyTunes();
  }

  _applyTunes() {
    SimpleImage.tunes.forEach( tune => {
      this.wrapper.classList.toggle(tune.name, !!this.data[tune.name]);
      if (tune.name === 'stretched') {
        Promise.resolve().then(() => {
          this.block.stretched = !!this.data.stretched;
        })
      }
    });
  }
}
