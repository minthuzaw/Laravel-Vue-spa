<template>
    <div class="card">
        <h3 class="card-header">
            Create
        </h3>
        <div class="card-body">
            <form action="">
                <div class="form-group my-2">
                    <label>Name :</label>
                    <input type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label>Price : </label>
                    <input v-model="" type="number" class="form-control">
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary mt-3"><i class="fas fa-save"></i> Save</button>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "CreateComponent"
}
</script>

<style scoped>

</style>
