/**
 * File uploader
 */
class FileUploader {
    fileList = null

    template = ''

    templateOptions = {
        name: 'name',
    }

    constructor(renderContainerId, fileListId, template) {

        const self = this
        this.renderContainerId = renderContainerId
        this.fileListId = fileListId
        this.template = template

        $(fileListId).on('change', (e) => {
            if (e !== undefined) {
                this.addFiles(e.target.files)
                e.target.value = ''
            }
        })

        $(document).on('click', '[data-file-remove-id]', function () {
            self.removeFile($(this).data('fileRemoveId'));
        })

        $(document).on('click', '.rotate-control', function () {
            const $rotateInput = $(this).find('input');
            const currentRotate = Number($rotateInput.val()) || 0;
            const newRotate = currentRotate;
            $(this).closest('[data-file-id]').find('.rotate-img')
                .css({'transform': `rotate(${newRotate}deg)`})

            $rotateInput.val(newRotate)
        })
    }

    readFileAsync = (file) => {
        return new Promise((resolve, reject) => {
            let reader = new FileReader();

            reader.onload = () => {
                resolve(reader.result);
            };

            reader.onerror = reject;

            reader.readAsDataURL(file);
        })
    }

    updateOutputInput = () => {
        const $fileListInput = $(this.fileListId)

        if ($fileListInput && this.fileList) {
            $fileListInput[0].files = this.fileList;
        }
    }

    addFiles = (files) => {
        const newFilesArr = Array.from(files)
        const allFiles = [...Array.from(this.fileList || []), ...newFilesArr]

        this.fileList = allFiles.reduce((dt, file) => {
            dt.items.add(file)

            return dt;
        }, new DataTransfer()).files;

        newFilesArr.forEach(async (file) => {
            const dataUrl = await this.readFileAsync(file);

            const filledTemplate = Object.entries(this.templateOptions).reduce((tmp, [key, value]) => {
                const output = tmp.replaceAll(`{{${key}}}`, file[value])

                return output
            }, this.template.replace('{{dataUrl}}', dataUrl))

            $(this.renderContainerId).prepend(filledTemplate)
        })

        this.updateOutputInput()
    }

    removeFile = (fileId) => {
        const dt = new DataTransfer()
        // const filteredFiles = Array.from(this.fileList).filter((file) => file.name !== fileId)
        // filteredFiles.forEach((file) => dt.items.add(file))

        // this.fileList = dt.files

        // this.updateOutputInput()

        $(`[data-file-id="${fileId}"]`).remove()
    }
}

new FileUploader(
    // container where will images rendered (prepend method useing)
    '#fileUploaderRenderContainer',
    // single input file element, all files will be merged there
    '#fileUploaderFiles',
    // render image templte
    // {{example}} - placeholders for templateOptions render (dataUrl at lest required)
    // data-file-id - container
    // data-file-remove-id - data for remove btn (whould has the same as container value)
    // .rotate-control button to rotate image
    // .rotate-img - element for rotating
    `<div class="mb-4 col" data-file-id="{{name}}">
      <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="mb-3 d-flex justify-content-center align-items-center photo">
          <img src="{{dataUrl}}" class="rotate-img">
        </div>
        
        <label class="mb-2 p-0 btn text-center text-primary">
          <input type="radio" name="fileMain" value="{{name}}" class="d-none" />
          Set as main
        </label>
  
        <div class="d-flex justify-content-around">
          <div class="mr-3 d-flex justify-content-center align-items-center element-control" data-file-remove-id="{{name}}">
            <i class="mr-2 icon-clear"></i>
            <span class="d-none d-lg-inline-block">Delete</span>
          </div>
  
          <div class="d-flex justify-content-center align-items-center element-control rotate-control">
            <input type="hidden" name="rotate[{{name}}]" value="0" />
            <i class="mr-2 icon-replay"></i>
            <span class="d-none d-lg-inline-block">Rotate</span>
          </div>
        </div>
      </div>
    </div>`,
)