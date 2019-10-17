import { throws } from "assert";

export default {
    state:{

        clientes: [],
        proveedores:[]
    },

    mutations:{

        setClientes(state,clientes){
            state.clientes = clientes;
        },

        setProveedor(state,proveedores){
            state.proveedores = proveedores;
        }
        
    },



    actions:{


        listarCliente({commit}){
            const clientes = []
            axios.get('cliente/listarCbo').then((resp)=>{
               let cliente = resp.data.cliente; 
               cliente.map(i =>{
                    clientes.push(i);
               });
            });

            commit('setClientes',clientes)
        },

        
        listarProveedor({commit}){
            const proveedores = []
            axios.get('proveedor/listarCbo').then((resp)=>{
               let cliente = resp.data.proveedor; 
               cliente.map(i =>{
                    proveedores.push(i);
               });
            });

            commit('setProveedor',proveedores)
        },

    }

}