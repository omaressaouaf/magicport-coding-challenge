import Alpine from "alpinejs";

Alpine.data("tasksComponent", () => ({
    loading: false,

    makeRequest(method, url, data) {
        return fetch(url, {
            method: method,
            body: data,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.head.querySelector(
                    "meta[name=csrf-token]"
                ).content,
            },
        });
    },

    async deleteTask(taskId) {
        this.loading = true;

        await this.makeRequest("delete", `/tasks/${taskId}`);

        this.tasks = this.tasks.filter((task) => task.id !== taskId);
    },
}));
