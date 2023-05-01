export interface User {
    id: number
    name: string
    email: string
}

export interface Token {
    id: number
    name: string
    abilities: string[]
    expires_at: string | null
    last_used_at: string | null
}

export interface FlashMessages {
    error?: string | null
    success?: string | null
}
