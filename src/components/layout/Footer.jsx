import { Link } from 'react-router-dom';
import { Sprout, Mail, MapPin, Phone, Linkedin, Twitter, Github } from 'lucide-react';
import styles from './Footer.module.css';

export default function Footer() {
    return (
        <footer className={styles.footer}>
            <div className="container">
                <div className={styles.footerGrid}>
                    {/* Brand */}
                    <div className={styles.brand}>
                        <div className={styles.logo}>
                            <span className={styles.logoIcon}>
                                <Sprout size={20} />
                            </span>
                            Seeda<span className={styles.logoDot}>.</span>
                        </div>
                        <p className={styles.brandDesc}>
                            We plant the seeds of digital innovation and nurture them into
                            solutions that grow your business. Software consulting done right.
                        </p>
                    </div>

                    {/* Quick Links */}
                    <div>
                        <h4 className={styles.colTitle}>Company</h4>
                        <Link to="/about" className={styles.footerLink}>About Us</Link>
                        <Link to="/services" className={styles.footerLink}>Services</Link>
                        <Link to="/case-studies" className={styles.footerLink}>Case Studies</Link>
                        <Link to="/contact" className={styles.footerLink}>Contact</Link>
                    </div>

                    {/* Services */}
                    <div>
                        <h4 className={styles.colTitle}>Services</h4>
                        <Link to="/services" className={styles.footerLink}>Software Dev</Link>
                        <Link to="/services" className={styles.footerLink}>Consulting</Link>
                        <Link to="/services" className={styles.footerLink}>Data & AI</Link>
                        <Link to="/services" className={styles.footerLink}>DevOps</Link>
                        <Link to="/services" className={styles.footerLink}>UI/UX Design</Link>
                    </div>

                    {/* Contact */}
                    <div>
                        <h4 className={styles.colTitle}>Get in Touch</h4>
                        <div className={styles.contactItem}>
                            <Mail size={16} />
                            <span>hello@seeda.dev</span>
                        </div>
                        <div className={styles.contactItem}>
                            <Phone size={16} />
                            <span>+39 02 1234 5678</span>
                        </div>
                        <div className={styles.contactItem}>
                            <MapPin size={16} />
                            <span>Milan, Italy</span>
                        </div>
                    </div>
                </div>

                {/* Bottom bar */}
                <div className={styles.footerBottom}>
                    <p>&copy; {new Date().getFullYear()} Seeda. All rights reserved.</p>
                    <div className={styles.socials}>
                        <a href="#" className={styles.socialLink} aria-label="LinkedIn">
                            <Linkedin size={16} />
                        </a>
                        <a href="#" className={styles.socialLink} aria-label="Twitter">
                            <Twitter size={16} />
                        </a>
                        <a href="#" className={styles.socialLink} aria-label="GitHub">
                            <Github size={16} />
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    );
}
