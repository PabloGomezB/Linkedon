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
                this.getOfertas();
            } else {
                this.axios
                    .get(
                        "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta?filter=categoria_id,eq," +
                            this.selected
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
        getOfertas() {
            this.axios
                .get(
                    "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta"
                )
                .then((response) => {
                    console.log("ofertas por categorias", response);
                    this.$parent.resultadoOfertas = response.data.records;
                });
        },
    },
    mounted() {
        this.getOfertas();
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
};
</script>

<style></style>
