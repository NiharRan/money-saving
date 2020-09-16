import BaseForm from 'vform';
import {serialize} from "object-to-formdata";

class Form extends BaseForm {

  constructor(data = {}) {
    super(data);

    this.progress = null;
  }

  startProcessing() {
    super.startProcessing();
    this.progress = 0;
  }

  finishProcessing() {
    super.finishProcessing();
    this.progress = null;
  }

  clear() {
    super.clear();
    this.progress = null;
  }

  async submit(method, url, config = {}) {

    let newConfig = Object.assign(config, {
      transformRequest: [function (data, headers) {
        return serialize(data)
      }],

      onUploadProgress: e => {
        this.progress = Math.round( (e.loaded * 100) / e.total )
      }
    })

    return await super.submit(method, url, newConfig);
  }
}

Form.ignore.push('progress');

export default Form;
