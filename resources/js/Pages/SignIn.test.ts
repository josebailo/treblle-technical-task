import { afterEach, describe, expect, test, vi } from 'vitest'
import { cleanup, fireEvent, render, screen } from '@testing-library/vue'
import SignIn from './SignIn.vue'

describe('SignIn component', () => {
    afterEach(() => {
        cleanup()
    })

    test('does not allow to do submit until the fields are filled', async () => {
        const mockSubmit = vi.fn()
        render(SignIn, { global: { mocks: { submit: mockSubmit } } })
        const submitButton = screen.getByRole('button')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const emailInput = screen.getByLabelText(/email/i)
        await fireEvent.update(emailInput, 'test@example.com')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const passwordInput = screen.getByLabelText(/password/i)
        await fireEvent.update(passwordInput, 'password')
        await fireEvent.click(submitButton)
        expect(mockSubmit).toHaveBeenCalled()
    })
})
