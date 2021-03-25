<template>
    <div>
        <!-- Cuando eliges una opcion se guarda en selected. Al principio es null -->
        <!-- Al cambiar de opcion (@change) filtra oferta por categoria -->
        <b-form-select
            v-model="selected"
            :options="options"
            @change="getOfertasPorCategoria()"
        ></b-form-select>
    </div>
</template>

<script>
export default {
    name: "SelectCategoria",
    data() {
        return {
            selected: null,
            // Este objeto son las opciones del select
            options: [{ value: null, text: "Selecciona una categoría" }],
        };
    },
    methods: {
        getOfertasPorCategoria() {
            if (this.selected == null) {
                //Si es null obtenemos todas las ofertas
                this.$emit("getOfertasEvent");
            } else {
                // Si no, los filtramos por categoria en el que el valor elegido esta en selected
                this.axios
                    .get(
                        "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta?filter=estat,eq,1&join=empresa_id,empresa&join=categoria_id,categoria&order=data_publicacio,asc&filter=categoria_id,eq," +
                            this.selected +
                            "&filter=data_publicacio,gt," +
                            this.getDate3MonthsSubstracted()
                    )
                    .then((response) => {
                        console.log(
                            "ofertas por categorias",
                            "change",
                            response
                        );
                        // Y lo guardamos en resultadoOfertas de el componente padre
                        // para que actualice la lista de oferta filtrada por categoria
                        this.$parent.resultadoOfertas = response.data.records;
                    });
            }
        },

        getCategorias() {
            //Obtenemos las categorias de BD y lo ponemos en las opciones del select con el push ya que es un array
            this.axios
                .get(
                    "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/categoria"
                )
                .then((response) => {
                    console.log("categorias", response.data.records);
                    response.data.records.forEach((categoriaElement) => {
                        this.options.push({
                            value: categoriaElement.id,
                            text: categoriaElement.descripcio,
                        });
                    });
                });
        },
        getDate3MonthsSubstracted() {
            let date = new Date();
            date.setMonth(date.getMonth() - 3);
            let month = date.getMonth() + 1;
            let day = date.getDate();
            let year = date.getFullYear();
            return year + "/" + month + "/" + day;
        },
    },
    mounted() {
        this.getCategorias();
    },
};
</script>

<style></style>
