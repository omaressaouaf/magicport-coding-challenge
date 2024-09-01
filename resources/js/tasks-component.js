import Alpine from "alpinejs";

Alpine.data("tasksComponent", () => ({
    currentTask: null,
    form: {
        name: null,
        description: null,
        status: null,
    },

    resetForm() {
        this.form = {
            name: null,
            description: null,
            status: null,
        };
    },
    makeRequest(method, url, data) {
        return fetch(url, {
            method: method,
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.head.querySelector(
                    "meta[name=csrf-token]"
                ).content,
            },
        });
    },
    async deleteTask(taskId) {
        await this.makeRequest("delete", `/tasks/${taskId}`);

        this.tasks = this.tasks.filter((task) => task.id !== taskId);
    },
    async createTask() {
        let response = await this.makeRequest(
            "post",
            `/projects/${this.currentProject.id}/tasks`,
            this.form
        );

        const task = await response.json();

        this.tasks.unshift(task);
    },
    async handleSubmit() {
        if (this.currentTask) {
        } else {
            this.createTask();
        }

        this.resetForm();
    },
}));
