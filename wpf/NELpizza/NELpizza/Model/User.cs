using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("users")]
    public class User
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "BIGINT UNSIGNED")]
        public long Id { get; set; }

        [Column("name", TypeName = "VARCHAR(255)")]
        public string Name { get; set; } = string.Empty;

        [Column("email", TypeName = "VARCHAR(255)")]
        public string Email { get; set; } = string.Empty;

        [Column("email_verified_at", TypeName = "TIMESTAMP")]
        public DateTime? EmailVerifiedAt { get; set; }

        [Column("password", TypeName = "VARCHAR(255)")]
        public string Password { get; set; } = string.Empty;

        [Column("remember_token", TypeName = "VARCHAR(100)")]
        public string? RememberToken { get; set; }

        [Column("created_at", TypeName = "TIMESTAMP")]
        public DateTime? CreatedAt { get; set; }

        [Column("updated_at", TypeName = "TIMESTAMP")]
        public DateTime? UpdatedAt { get; set; }

        public virtual ICollection<KlantUser> KlantUsers { get; set; } = new HashSet<KlantUser>();
    }
}