import { Mail, Phone, MapPin, Clock } from 'lucide-react';
import ContactForm from '../components/contact/ContactForm';
import ScrollReveal from '../components/ui/ScrollReveal';
import pageStyles from '../styles/PageHeader.module.css';
import styles from './ContactPage.module.css';

export default function ContactPage() {
    return (
        <>
            <section className={pageStyles.pageHeader}>
                <div className="container">
                    <ScrollReveal>
                        <h1>Get in Touch</h1>
                        <p>
                            Have a project in mind? We'd love to hear about it. Drop us a
                            message and we'll get back to you within 24 hours.
                        </p>
                    </ScrollReveal>
                </div>
            </section>

            <section className={styles.contactPage}>
                <div className="container">
                    <div className={styles.contactGrid}>
                        {/* Form */}
                        <ScrollReveal className="fade-in-left">
                            <ContactForm />
                        </ScrollReveal>

                        {/* Sidebar */}
                        <ScrollReveal className="fade-in-right">
                            <div className={styles.sidebar}>
                                <h3 className={styles.sidebarTitle}>Contact Information</h3>

                                <div className={styles.infoItem}>
                                    <div className={styles.infoIcon}>
                                        <Mail size={20} />
                                    </div>
                                    <div>
                                        <h4>Email</h4>
                                        <p>hello@seeda.dev</p>
                                    </div>
                                </div>

                                <div className={styles.infoItem}>
                                    <div className={styles.infoIcon}>
                                        <Phone size={20} />
                                    </div>
                                    <div>
                                        <h4>Phone</h4>
                                        <p>+39 02 1234 5678</p>
                                    </div>
                                </div>

                                <div className={styles.infoItem}>
                                    <div className={styles.infoIcon}>
                                        <MapPin size={20} />
                                    </div>
                                    <div>
                                        <h4>Office</h4>
                                        <p>Milan, Italy</p>
                                    </div>
                                </div>

                                <div className={styles.infoItem}>
                                    <div className={styles.infoIcon}>
                                        <Clock size={20} />
                                    </div>
                                    <div>
                                        <h4>Business Hours</h4>
                                        <p>Mon – Fri, 9:00 – 18:00 CET</p>
                                    </div>
                                </div>

                                <div className={styles.mapPlaceholder}>
                                    📍 Map placeholder
                                </div>
                            </div>
                        </ScrollReveal>
                    </div>
                </div>
            </section>
        </>
    );
}
