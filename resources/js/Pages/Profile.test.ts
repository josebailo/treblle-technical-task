import { afterEach, describe, expect, test, vi } from 'vitest'
import { cleanup, fireEvent, render, screen } from '@testing-library/vue'
import Profile from './Profile.vue'

describe('Profile component', () => {
    afterEach(() => {
        cleanup()
    })

    test('does not allow to do submit until the fields are filled', async () => {
        const mockSubmit = vi.fn()
        render(Profile, {
            props: {
                user: {
                    name: 'John Doe',
                    email: 'test@example.com',
                },
            },
            global: {
                mocks: {
                    submit: mockSubmit,
                },
            },
        })
        const submitButton = screen.getByRole('button')
        const nameInput = screen.getByLabelText(/name/i)
        const emailInput = screen.getByLabelText(/email/i)

        await fireEvent.update(nameInput, '')
        await fireEvent.update(emailInput, '')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        await fireEvent.update(nameInput, 'John Doe')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        await fireEvent.update(emailInput, 'test@example.com')
        await fireEvent.click(submitButton)
        expect(mockSubmit).toHaveBeenCalled()
    })

    test('have the fields already filled with the user data', async () => {
        render(Profile, {
            props: {
                user: {
                    name: 'John Doe',
                    email: 'test@example.com',
                },
            },
        })
        expect(screen.getByLabelText(/name/i).value).toBe('John Doe')
        expect(screen.getByLabelText(/email/i).value).toBe('test@example.com')
    })
})
