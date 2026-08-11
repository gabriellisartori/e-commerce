# frontend

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).


# Use toast
import { toast } from 'vue3-toastify';
toast.success("Ingrediente salvo!", {
      position: toast.POSITION.BOTTOM_LEFT,
});

# Use confirm dialog
this.$swal.fire({
  title: 'Oppss...',
  text: 'Something went wrong!',
  showCancelButton: true,
  confirmButtonText: 'Salvar',
  cancelButtonText: 'Cancelar',
  icon: 'warning',
  focusConfirm: false
}).then((result) => {
  console.log(result);
})

