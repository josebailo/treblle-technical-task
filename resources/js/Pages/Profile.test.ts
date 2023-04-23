import { afterEach, describe, expect, test, vi } from 'vitest'
import { cleanup, fireEvent, render, screen } from '@testing-library/vue'
import Profile from './Profile.vue'

describe('Profile component', () => {
    afterEach(() => {
        cleanup()
    })

    // TODO find out how to mock the properties that came from laravel
    test.skip('does not allow to do submit until the fields are filled', async () => {
        const mockSubmit = vi.fn()
        render(Profile, {
            global: {
                mocks: {
                    $page: {
                        props: {
                            auth: {
                                user: {
                                    name: 'John Doe',
                                    email: 'test@example.com',
                                },
                            },
                        },
                    },
                    submit: mockSubmit,
                },
            },
        })
        const submitButton = screen.getByText(/update/i)
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const nameInput = screen.getByLabelText(/name/i)
        await fireEvent.update(nameInput, 'John Doe')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const emailInput = screen.getByLabelText(/email/i)
        await fireEvent.update(emailInput, 'test@example.com')
        await fireEvent.click(submitButton)
        expect(mockSubmit).toHaveBeenCalled()
    })
})
