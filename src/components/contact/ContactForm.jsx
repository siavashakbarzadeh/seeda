import { useState } from 'react';
import Button from '../ui/Button';
import styles from './ContactForm.module.css';

const INITIAL_STATE = { name: '', email: '', company: '', service: '', message: '' };

export default function ContactForm() {
    const [form, setForm] = useState(INITIAL_STATE);
    const [errors, setErrors] = useState({});
    const [submitted, setSubmitted] = useState(false);

    const validate = () => {
        const errs = {};
        if (!form.name.trim()) errs.name = 'Name is required';
        if (!form.email.trim()) errs.email = 'Email is required';
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) errs.email = 'Invalid email address';
        if (!form.message.trim()) errs.message = 'Message is required';
        return errs;
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setForm((prev) => ({ ...prev, [name]: value }));
        if (errors[name]) setErrors((prev) => ({ ...prev, [name]: '' }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const errs = validate();
        if (Object.keys(errs).length > 0) {
            setErrors(errs);
            return;
        }
        // TODO: Replace with actual API call or Formspree integration
        console.log('Form submitted:', form);
        setSubmitted(true);
        setForm(INITIAL_STATE);
    };

    if (submitted) {
        return (
            <div className={styles.success}>
                🎉 Thank you! We've received your message and will get back to you within 24 hours.
            </div>
        );
    }

    return (
        <form className={styles.contactForm} onSubmit={handleSubmit} noValidate>
            <div className={styles.formRow}>
                <div className={styles.formGroup}>
                    <label htmlFor="name">Full Name *</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        placeholder="Your name"
                        value={form.name}
                        onChange={handleChange}
                    />
                    {errors.name && <span className={styles.error}>{errors.name}</span>}
                </div>
                <div className={styles.formGroup}>
                    <label htmlFor="email">Email *</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="you@company.com"
                        value={form.email}
                        onChange={handleChange}
                    />
                    {errors.email && <span className={styles.error}>{errors.email}</span>}
                </div>
            </div>

            <div className={styles.formRow}>
                <div className={styles.formGroup}>
                    <label htmlFor="company">Company</label>
                    <input
                        id="company"
                        name="company"
                        type="text"
                        placeholder="Your company name"
                        value={form.company}
                        onChange={handleChange}
                    />
                </div>
                <div className={styles.formGroup}>
                    <label htmlFor="service">Service of Interest</label>
                    <select id="service" name="service" value={form.service} onChange={handleChange}>
                        <option value="">Select a service</option>
                        <option value="software-development">Software Development</option>
                        <option value="consulting">Technology Consulting</option>
                        <option value="data-ai">Data & AI Solutions</option>
                        <option value="devops">DevOps & Cloud</option>
                        <option value="uiux-design">UI/UX Design</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div className={styles.formGroup}>
                <label htmlFor="message">Message *</label>
                <textarea
                    id="message"
                    name="message"
                    placeholder="Tell us about your project..."
                    value={form.message}
                    onChange={handleChange}
                />
                {errors.message && <span className={styles.error}>{errors.message}</span>}
            </div>

            <Button type="submit" size="lg">
                Send Message
            </Button>
        </form>
    );
}
