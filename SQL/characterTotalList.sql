
-- Fragt die Daten ab, die für die Darstellung der Kämpferliste im PreLogin benötigt wird.
SELECT 
    x.name,
    x.gender,
    x.coloredName,
    x.title,
    x.is_in_front,
    x.guildName,
    x.guildTag,
    x.raceName,
    x.level,
    x.locationTitle,
    x.dead,
    x.last_active,
    x.is_online
FROM
    (SELECT 
        c.name,
            c.gender,
            c.level,
            c.dead,
            c.last_active,
            c.is_online,
            n.name AS coloredName,
            n.is_activated AS nActivated,
            t.title,
            t.is_in_front,
            t.is_activated AS tActivated,
            g.name AS guildName,
            g.tag AS guildTag,
            r.name AS raceName,
            l.name AS locationTitle
    FROM
        characters c
    LEFT JOIN character_names n ON c.id = n.owner_id
    LEFT JOIN character_titles t ON c.id = t.owner_id
    LEFT JOIN guilds g ON c.guild_id = g.id
    LEFT JOIN races r ON c.race_id = r.id
    LEFT JOIN locations l ON c.location_id = l.id) x
WHERE
    x.coloredName IS NULL
        OR x.nActivated = 1
        AND (x.title IS NULL OR x.tActivated = 1)