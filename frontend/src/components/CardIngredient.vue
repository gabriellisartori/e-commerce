<script setup>
</script>

<template>
    <div class="card-ingredient">
        <div class="icons">
            <img src="../assets/icons/edit.png">
            <img src="../assets/icons/exit.png">
        </div>
        <p class="item">Tomate</p>
    </div>
</template>

<style lang="scss">
.card-ingredient{
    width: 400px;
    height: 100px;
    border: 1px solid #5F8A17;
    border-left: 15px solid #5F8A17;
    border-radius: 10px;
    margin-top: 42px;
    
    .icons{
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin: 10px;

        img{
            width: 4%;
            height: 4%;
            margin-right: 10px;
        }
    }

    .item{
        text-align: start;
        font-weight: 700;
        margin-left: 30px;
        font-size: 20px;
    }
}
</style>