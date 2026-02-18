import { Linkedin } from 'lucide-react';
import Card from '../ui/Card';
import styles from './TeamMemberCard.module.css';

const COLORS = ['#16A34A', '#2563EB', '#9333EA', '#EA580C', '#0891B2', '#DB2777'];

export default function TeamMemberCard({ member, index = 0 }) {
    const initials = member.name
        .split(' ')
        .map((w) => w[0])
        .join('');

    const color = COLORS[index % COLORS.length];

    return (
        <Card className={styles.teamCard}>
            <div
                className={styles.avatar}
                style={{ background: `linear-gradient(135deg, ${color}, ${color}cc)` }}
            >
                {initials}
            </div>
            <h3 className={styles.name}>{member.name}</h3>
            <p className={styles.role}>{member.role}</p>
            <p className={styles.bio}>{member.bio}</p>
            {member.linkedin && (
                <a href={member.linkedin} className={styles.socialLink} aria-label={`${member.name}'s LinkedIn`}>
                    <Linkedin size={16} />
                </a>
            )}
        </Card>
    );
}
