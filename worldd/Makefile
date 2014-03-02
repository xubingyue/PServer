NAME=worldd
CINC= 
LDPATH= 
DEPLIBS=

# Default settings
PREFIX?=/usr/local/$(NAME)
INSTALL_BIN=$(PREFIX)/bin


CCCOLOR="\033[34m"
LINKCOLOR="\033[34;1m"
SRCCOLOR="\033[33m"
BINCOLOR="\033[37;1m"
MAKECOLOR="\033[32;1m"
ENDCOLOR="\033[0m"

QUIET_CC = @printf '    %b %b\n' $(CCCOLOR)CC$(ENDCOLOR) $(SRCCOLOR)$@$(ENDCOLOR) 1>&2;
QUIET_LINK = @printf '    %b %b\n' $(LINKCOLOR)LINK$(ENDCOLOR) $(BINCOLOR)$@$(ENDCOLOR) 1>&2;
QUIET_AR = @printf '    %b %b\n' $(LINKCOLOR)AR$(ENDCOLOR) $(BINCOLOR)$@$(ENDCOLOR) 1>&2;
QUIET_INSTALL = @printf '    %b %b\n' $(LINKCOLOR)INSTALL$(ENDCOLOR) $(BINCOLOR)$@$(ENDCOLOR) 1>&2;

CC = gcc
AR = ar
RM = /bin/rm -f
INSTALL=cp -pf

ifdef MAKE_RELEASE
CFLAGS = -std=c99 -pedantic -Wall -Wconversion -Wcast-qual -Wpointer-arith -Wredundant-decls -Wmissing-declarations -Werror --pipe -O3 $(CINC) -DMAKE_RELEASE
else
CFLAGS = -std=c99 -pedantic -Wall -Wconversion -Wcast-qual -Wpointer-arith -Wredundant-decls -Wmissing-declarations -Werror --pipe -g -ggdb $(CINC) -DMAKE_DEBUG
endif


REALCC=$(QUIET_CC)$(CC) $(CFLAGS)
REALLD=$(QUIET_LINK)$(CC) $(LDPATH) $(DEPLIBS)
REALAR=$(QUIET_AR)$(AR)
REALINSTALL=$(QUIET_INSTALL)$(INSTALL)



.PHONY: all clean
TDATA_FILE=$(wildcard *.td)

TYPES_HFILE=$(TDATA_FILE:.td=_types.h)
READER_HFILE=$(TDATA_FILE:.td=_reader.h)
WRITER_HFILE=$(TDATA_FILE:.td=_writer.h)
READER_CFILE=$(TDATA_FILE:.td=_reader.c)
WRITER_CFILE=$(TDATA_FILE:.td=_writer.c)

C_FILE=$(wildcard *.c) $(wildcard timer/*.c)
OBJECT_FILE=$(C_FILE:.c=.o) $(READER_CFILE:.c=.o) $(WRITER_CFILE:.c=.o)
LIB=lib$(NAME).a
APP=$(NAME)
TARGET=$(APP)

.PHONY: all clean

%_types.h:%.td
	tdata -s $(SOURCE_PATH) -t $(SOURCE_PATH) -gen tlibc_types $(NAME)/$<

%_reader.h:%.td %_types.h
	tdata -s $(SOURCE_PATH) -t $(SOURCE_PATH) -gen tlibc_reader_header $(NAME)/$<

%_writer.h:%.td %_types.h
	tdata -s $(SOURCE_PATH) -t $(SOURCE_PATH) -gen tlibc_writer_header $(NAME)/$<

%_reader.c:%.td %_reader.h %_types.h
	tdata -s $(SOURCE_PATH) -t $(SOURCE_PATH) -gen tlibc_reader $(NAME)/$<
	
%_writer.c:%.td %_writer.h %_types.h
	tdata -s $(SOURCE_PATH) -t $(SOURCE_PATH) -gen tlibc_writer $(NAME)/$<

%.o: %.c
	$(REALCC) -c $<

all:$(TYPES_HFILE) $(READER_HFILE) $(WRITER_HFILE) $(TARGET) 

$(LIB): $(OBJECT_FILE)
	$(REALAR) r $(LIB) $^

$(APP): $(OBJECT_FILE)
	$(REALLD) -o $@ $^ 

install:
	@mkdir -p $(INSTALL_BIN)
	$(REALINSTALL) $(APP) $(INSTALL_BIN)

tags:
	@find /usr/local/tlibc/include/ -name "*.h" | xargs ctags -a --c-types=+p+x 
	@find . -name "*.c" -or -name "*.h" | xargs ctags -a --c-types=+p+x
	@find . -name "*.h" -or -name "*.c" | cscope -Rbq

clean:
	@find . -name "*.o" | xargs $(RM)
	@find . -name "*.d" | xargs $(RM)
	@$(RM) $(TARGET) $(TYPES_HFILE) $(READER_HFILE) $(WRITER_HFILE) $(READER_CFILE) $(WRITER_CFILE) tags cscope.in.out cscope.po.out cscope.out
