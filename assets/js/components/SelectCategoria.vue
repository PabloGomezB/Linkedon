<template>
    <div>
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
            options: [{ value: null, text: "Selecciona una categoría" }],
        };
    },
    methods: {
        getOfertasPorCategoria() {
            if (this.selected == null) {
                this.$emit("getOfertasEvent");
            } else {
                this.axios
                    .get(
                        "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta?filter=categoria_id,eq," +
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
                        this.$parent.resultadoOfertas = response.data.records;
                    });
            }
        },

        getCategorias() {
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
