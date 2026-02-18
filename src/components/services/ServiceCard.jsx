import { Check } from 'lucide-react';
import * as LucideIcons from 'lucide-react';
import Card from '../ui/Card';
import styles from './ServiceCard.module.css';

/**
 * ServiceCard — renders a single service with icon, description, and feature list.
 * Icons are resolved dynamically from the icon name in services.json.
 */
export default function ServiceCard({ service }) {
    const IconComponent = LucideIcons[service.icon] || LucideIcons.Code2;

    return (
        <Card className={styles.serviceCard}>
            <div className={styles.iconWrap}>
                <IconComponent size={26} />
            </div>
            <p className={styles.subtitle}>{service.subtitle}</p>
            <h3 className={styles.title}>{service.title}</h3>
            <p className={styles.description}>{service.description}</p>
            <ul className={styles.features}>
                {service.features.map((feature) => (
                    <li key={feature}>
                        <Check size={16} className={styles.featureIcon} />
                        {feature}
                    </li>
                ))}
            </ul>
        </Card>
    );
}
