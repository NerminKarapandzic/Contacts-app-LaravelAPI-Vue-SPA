<template>
    <div
        class="rounded-full text-white bg-blue-400 w-10 h-10 flex items-center justify-center border-gray-400"
    >
        {{ userName }}
    </div>
</template>

<script>
export default {
    name: "userCircle",
    props: ["name"],
    computed: {
        userName: function() {
            return this.name
                .match(/[A-Z]/g)
                .slice(0, 2)
                .join("");
        }
    }
};
</script>
