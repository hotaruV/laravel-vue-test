<template>
    <div class="app-body">
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="todos">Todos</option>
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarUsaurios(1,buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarUsaurios(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Estado</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="usuario in arrayUsuarios" :key='usuario.id'>
                                     <td v-text="usuario.id"></td>
                                    <td v-text="usuario.name"></td>
                                    <td v-text="usuario.lastname"></td>
                                    <td v-text="usuario.email"></td>
                                    <td>
                                        <div v-if="usuario.active == 1">
                                            <a href="#" @click="desactivar(usuario.id)"><span class="badge badge-success">Activo</span></a>
                                        </div>
                                        <div v-else>
                                            <a href="#" @click="activar(usuario.id)"><span class="badge badge-danger">Desactivado</span></a>
                                        </div>
                                    </td>
                               </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page >= pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.first_page = 1, buscar, criterio)">Primero</a>
                                </li>
                               <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar,criterio)">Anterior</a>
                                </li>
                                <li class="page-item" v-for="page in pageNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page != 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.last_page, buscar, criterio)">Último</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            
            
            
            
        </div>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      lastname: "",
      arrayUsuarios: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        first_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },

      offset: 3,
      criterio: "todos",
      buscar: ""
    };
  },
  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    pageNumber: function() {
      if (!this.pagination.to) {
        return [];
      }
      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pageArray = [];
      while (from <= to) {
        pageArray.push(from);
        from++;
      }
      return pageArray;
    }
  },
  methods: {
    listarUsaurios(page, buscar, criterio) {
      let me = this;
      let url =
        "/usuario?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
      axios
        .get(url)
        .then(function(res) {
          let respuesta = res.data;
          me.arrayUsuarios = respuesta.usuarios.data;
          me.pagination = respuesta.pagination;
        })
        .catch(error => {
          console.log(error);
        });
    },
    desactivar(id) {
        let me = this;
      axios
        .put("/usuario/desactivar", {
          id: id
        })
        .then(function(res) {
          let respuesta = res.data;
          me.listarUsaurios(1, '', 'todos');
        })
        .catch(error => {
          console.log(error);
        });
    },
    activar(id) {
        let me = this;
      axios
        .put("/usuario/activar", {
          id: id
        })
        .then(function(res) {
          let respuesta = res.data;
          me.listarUsaurios(1, '', 'todos');
        })
        .catch(error => {
          console.log(error);
        });
    },

    cambiarPagina(page, buscar, criterio) {
      let me = this;
      me.pagination.current_page = page;
      me.listarUsaurios(page, buscar, criterio);
    }
  },
  mounted() {
    this.listarUsaurios(1, this.buscar, this.criterio);
  }
};
</script>
