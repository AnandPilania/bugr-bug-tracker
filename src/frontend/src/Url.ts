
const Url = {
    root: '/',
    auth: {
        login: '/login',
        logout: '/logout',
        profile: '/user/profile',
        register: '/register',
    },
    api: {
        login: '/login',
        logout: '/logout',
        register: '/register',
        validateToken: '/user/validate',
        changePassword: '/user/password',
        dashboard: '/dashboard',
        bugs: {
            create: '/bugs'
        },
        projects: {
            all: '/projects',
            bugs: (id: number) => `/project/${id}/bugs`,
            create: '/projects',
            get: (id: number) => `/project/${id}`,
            delete: (id: number) => `/project/${id}`
        },
        statuses: {
            create: '/status',
            changeOnKanban: '/status/kanban',
            swap: '/status/swap'
        },
        tags: {
            byProject: (projectId: number) => `/project/${projectId}/tags`,
            create: '/tag'
        }
    },
    bugs: {
        byProject: (projectId: number) => `/project/${projectId}/bugs`,
        view: (id: number) => `/bug/${id}`,
        setStatus: (id: number) => `/bug/${id}/status`
    },
    projects: {
        all: '/projects',
        view: (id: number) => `/project/${id}`,  // this is a function to use to generate a url
        one: '/project/:projectId',       // this is the url that the above function generates to we can navigate to it
        kanban: (projectId: number) => `/project/${projectId}/kanban`,
    },
    statuses: {
        byProject: (projectId: number) => `/project/${projectId}/statuses`
    },
    kanban: {
        root: '/kanban',
        project: '/project/:projectId/kanban'
    }
}

export default Url
