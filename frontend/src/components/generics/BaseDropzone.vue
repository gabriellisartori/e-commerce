<script>
import { reactive, watch } from 'vue';
import { useDropzone } from 'vue3-dropzone';

export default {
    name: 'DropzoneComponent',
    props: {
        sendFileToParent: Function,
        label: String
    },
    setup(props) {
        let deleteFileHandler;

        const state = reactive({
            files: [],
        });

        const { getRootProps, getInputProps, isDragActive, ...rest } = useDropzone({
            onDrop,
        });

        function onDrop(acceptFiles) {
            if (acceptFiles.length > 0) {
                const file = acceptFiles[0]; 
                if (file instanceof File) {
                    state.files = [file]; 
                    props.sendFileToParent(file); 
                } else {
                    console.error('O objeto aceito não é um arquivo válido:', file);
                }
            }
        }


        function handleClickDeleteFile(index) {
            state.files.splice(index, 1);
        }

        watch(() => state.files, (newValue) => {
            console.log('state', newValue);
        });

        watch(() => isDragActive.value, (newValue) => {
            console.log('isDragActive', newValue, rest);
        });

        deleteFileHandler = handleClickDeleteFile;

        return {
            state,
            getRootProps,
            getInputProps,
            isDragActive,
            deleteFileHandler,
        };
    },
};
</script>

<template>
    <div>
        <label class="base-label">{{ label }}</label>
        <div v-if="state.files.length > 0" class="files">
            <div class="file-item" v-for="(file, index) in state.files" :key="index">
                <span>{{ file.name }}</span>
                <span class="delete-file" @click="deleteFileHandler(index)">Delete</span>
            </div>
        </div>
        <div v-else class="dropzone" v-bind="getRootProps()">
            <div class="border" :class="{ isDragActive }">
                <input v-bind="getInputProps()" />
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512">
                    <path
                        d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z" />
                </svg>
            </div>
            <base-button class="button" color="dark-green" isOutlined>UPLOAD</base-button>
        </div>
    </div>
</template>
  
<style scoped lang="scss">
.dropzone,
.files {
    width: 100%;
    margin-bottom: 20px;
    border-radius: 8px;
    font-size: 12px;
    line-height: 1.5;
}

.border {
    margin-top: 10px;
    border: 1px dashed var(--cor-primaria);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    transition: all 0.3s ease;
    background: #fff;
    cursor: pointer;

    &.isDragActive {
        border: 2px dashed #ffb300;
        background: rgb(255 167 18 / 20%);
    }

    .icon {
        width: 35px;
        height: 35px;
        font-size: 16px;
        margin: 0 8px;
        fill: var(--cor-secundaria);
    }
}

.file-item {
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--cor-site);
    padding: 7px;
    padding-left: 15px;
    margin-top: 10px;
    border: 1px solid var(--cor-primaria);

    .delete-file {
        background: var(--cor-secundaria);
        color: #fff;
        padding: 5px 10px;
        border-radius: 8px;
        cursor: pointer;
    }
}

.button {
    width: 100%;
    margin-top: 15px;
    margin-left: 0px !important;
}
</style>